<?php

namespace App\Http\Controllers\API\Tracker;

use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Game;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use JsonException;
use Laravel\Sanctum\PersonalAccessToken;

class IncomingDataController extends Controller
{
    private User $user;
    private City $pickupCity;
    private City $destinationCity;
    private Company $pickupCompany;
    private Company $destinationCompany;
    private Cargo $cargo;
    private int $gameId;
    private int $cargoDamage;

    /**
     * Handle the incoming tracker request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function handleRequest(Request $request): JsonResponse
    {
        // Get the user
        $this->user = $request->user();

        // Decode the request content
        try {
            $data = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return response()->json([
                'error' => true,
                'descriptor' => 'Invalid request content'
            ], 400);
        }

        if (isset($data->job->income) && $data->job->income !== 0) {
            try {
                $this->processJobData($data);
            } catch (Exception $e) {
                return response()->json([
                    'error' => true,
                    'descriptor' => 'Invalid request content'
                ], 400);
            }
        }

        return response()->json(['error' => false]);
    }

    private function processJobData(object $data): void
    {
        $this->gameId = $data->game->game->id;

        $this->cargoDamage = round($data->job->cargo->damage / 0.01);

        // Find or create the job
        $job = $this->findOrCreateJob($data);

        // Return if the found job is already completed (just to be sure)
        if ($job->status === JobStatus::Complete) {
            return;
        }

        // Set the job to PendingVerification if a city/company/cargo is unapproved
        if (!$this->pickupCity->approved || !$this->destinationCity->approved || !$this->pickupCompany->approved || !$this->destinationCompany->approved || !$this->cargo->approved) {
            $job->status = JobStatus::PendingVerification;
        }

        // Update the cargo damage
        $job->load_damage = $this->cargoDamage;

        $job->save();
    }

    private function findOrCreateJob(object $data): Job
    {
        // Handle distance conversion
        if ($this->gameId === 2) {
            $distance = $data->job->plannedDistance->miles;
        } else {
            $distance = $data->job->plannedDistance->km;
        }

        // Round the distance up
        $distance = ceil($distance);

        $job = Job::query()
            ->where('user_id', $this->user->id)
            ->where('game_id', $this->gameId)
            ->where('pickup_city_id', ($this->pickupCity = $this->findOrCreateCity($data->job->source->city->id, $data->job->source->city->name))->id)
            ->where('destination_city_id', ($this->destinationCity = $this->findOrCreateCity($data->job->destination->city->id, $data->job->destination->city->name))->id)
            ->where('pickup_company_id', ($this->pickupCompany = $this->findOrCreateCompany($data->job->source->company->name, $data->job->isSpecial))->id)
            ->where('destination_company_id', ($this->destinationCompany = $this->findOrCreateCompany($data->job->destination->company->name, $data->job->isSpecial))->id)
            ->where('cargo_id', ($this->cargo = $this->findOrCreateCargo($data->job->cargo))->id)
            ->where('tracker_job', true)
            ->where('status', '!=', JobStatus::Complete);

        // Return the job if it exists
        if ($job->exists()) {
            return $job->firstOrFail();
        }

        // The job doesn't exist, so create it
        return Job::query()
            ->create([
                'user_id' => $this->user->id,
                'game_id' => $this->gameId,
                'pickup_city_id' => ($this->pickupCity = $this->findOrCreateCity($data->job->source->city->id, $data->job->source->city->name))->id,
                'destination_city_id' => ($this->destinationCity = $this->findOrCreateCity($data->job->destination->city->id, $data->job->destination->city->name))->id,
                'pickup_company_id' => ($this->pickupCompany = $this->findOrCreateCompany($data->job->source->company->name, $data->job->isSpecial))->id,
                'destination_company_id' => ($this->destinationCompany = $this->findOrCreateCompany($data->job->destination->company->name, $data->job->isSpecial))->id,
                'cargo_id' => ($this->cargo = $this->findOrCreateCargo($data->job->cargo))->id,
                'estimated_income' => $data->job->income,
                'total_income' => $data->job->income,
                'tracker_job' => true,
                'started_at' => Carbon::now(),
                'load_damage' => $this->cargoDamage,
                'distance' => $distance
            ]);
    }

    private function findOrCreateCity(string $cityId, string $cityName): City
    {
        // Return the city if found
        if (($city = City::query()->firstWhere('name', $cityId))) {
            return $city;
        }

        // Request city data from Trucky
        $request = Http::get('https://api.truckyapp.com/v2/map/cities/' . Game::getAbbreviationById($this->gameId));

        // If the request returned a 200 & the response key exists
        if ($request->ok() && $request['response']) {
            // Collect the response
            $request = collect($request['response']);

            // Get the first result where the in_game_id matches the $cityId
            $result = $request->firstWhere('in_game_id', $cityId);

            // If there is a result, create an approved city with the Trucky data
            if ($result) {
                return City::query()->create([
                    'real_name' => $result['realName'],
                    'name' => $result['in_game_id'],
                    'country' => $result['country'],
                    'dlc' => $result['dlc'],
                    'mod' => $result['mod'],
                    'x' => $result['x'],
                    'z' => $result['z'],
                    'game_id' => $this->gameId,
                    'requested_by' => $this->user->id,
                ]);
            }
        }

        // Otherwise, request the city
        return City::query()->create([
            'real_name' => $cityName,
            'name' => $cityId,
            'country' => 'Unknown (Automatic Tracker Request)',
            'dlc' => 'Unknown (Automatic Tracker Request)',
            'mod' => 'Unknown (Automatic Tracker Request)',
            'game_id' => $this->gameId,
            'approved' => false,
            'requested_by' => $this->user->id,
        ]);
    }

    private function findOrCreateCompany(string $companyName, bool $isSpecial): Company
    {
        // Handle special transport job
        if ($isSpecial) {
            return Company::firstOrCreate([
                'name' => 'Special Transport',
            ], [
                'dlc' => 'Special Transport',
                'game_id' => $this->gameId,
            ]);
        }

        return Company::firstOrCreate([
            'name' => $companyName,
        ], [
            'category' => 'Unknown (Automatic Tracker Request)',
            'specialization' => 'Unknown (Automatic Tracker Request)',
            'dlc' => 'Unknown (Automatic Tracker Request)',
            'mod' => 'Unknown (Automatic Tracker Request)',
            'game_id' => $this->gameId,
            'approved' => false,
            'requested_by' => $this->user->id,
        ]);
    }

    private function findOrCreateCargo(object $cargo): Cargo
    {
        // Handle cargo weight conversion
        if ($this->gameId === 2) {
            // Convert kilos to pounds
            $weight = round($cargo->mass * 2.205);
        } else {
            // Convert kilos to tonnes
            $weight = round($cargo->mass / 1000);
        }

        return Cargo::firstOrCreate([
            'name' => $cargo->name,
        ], [
            'dlc' => 'Unknown (Automatic Tracker Request)',
            'mod' => 'Unknown (Automatic Tracker Request)',
            'weight' => $weight,
            'game_id' => $this->gameId,
            'approved' => false,
            'requested_by' => $this->user->id,
        ]);
    }
}
