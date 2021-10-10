<?php

namespace App\Http\Controllers\API\Tracker;

use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JsonException;
use Laravel\Sanctum\PersonalAccessToken;

class IncomingDataController extends Controller
{
    private User $user;

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
        $gameId = $data->game->game->id;
        $cargoDamage = round($data->job->cargo->damage / 0.01);

        // Handle distance conversion
        if ($gameId === 2) {
            $distance = $data->job->plannedDistance->miles;
        } else {
            $distance = $data->job->plannedDistance->km;
        }

        // Round the distance up
        $distance = ceil($distance);

        // Find or create the job
        $job = Job::firstOrCreate([
            'user_id' => $this->user->id,
            'game_id' => $gameId,
            'pickup_city_id' => ($pickupCity = $this->findOrCreateCity($data->job->source->city->name, $gameId))->id,
            'destination_city_id' => ($destinationCity = $this->findOrCreateCity($data->job->destination->city->name, $gameId))->id,
            'pickup_company_id' => ($pickupCompany = $this->findOrCreateCompany($data->job->source->company->name, $gameId, $data->job->isSpecial))->id,
            'destination_company_id' => ($destinationCompany = $this->findOrCreateCompany($data->job->destination->company->name, $gameId, $data->job->isSpecial))->id,
            'cargo_id' => ($cargo = $this->findOrCreateCargo($data->job->cargo, $gameId))->id,
            'estimated_income' => $data->job->income,
            'total_income' => $data->job->income,
            'tracker_job' => true,
        ], [
            'started_at' => Carbon::now(),
            'load_damage' => $cargoDamage,
            'distance' => $distance
        ]);

        // Return if the found job is already completed (just to be sure)
        if ($job->status === JobStatus::Complete) {
            return;
        }

        // Set the job to PendingVerification if a city/company/cargo is unapproved
        if (!$pickupCity->approved || !$destinationCity->approved || !$pickupCompany->approved || !$destinationCompany->approved || !$cargo->approved) {
            $job->status = JobStatus::PendingVerification;
        }

        // Update the cargo damage
        $job->load_damage = $cargoDamage;

        $job->save();
    }

    private function findOrCreateCity(string $sourceCity, int $gameId): City
    {
        return City::firstOrCreate([
            'real_name' => $sourceCity,
        ], [
            'name' => Str::snake($sourceCity),
            'country' => 'Unknown (Automatic Tracker Request)',
            'dlc' => 'Unknown (Automatic Tracker Request)',
            'mod' => 'Unknown (Automatic Tracker Request)',
            'game_id' => $gameId,
            'approved' => false,
            'requested_by' => $this->user->id,
        ]);
    }

    private function findOrCreateCompany(string $companyName, int $gameId, bool $isSpecial): Company
    {
        // Handle special transport job
        if ($isSpecial) {
            return Company::firstOrCreate([
                'name' => 'Special Transport',
            ], [
                'dlc' => 'Special Transport',
                'game_id' => $gameId,
            ]);
        }

        return Company::firstOrCreate([
            'name' => $companyName,
        ], [
            'category' => 'Unknown (Automatic Tracker Request)',
            'specialization' => 'Unknown (Automatic Tracker Request)',
            'dlc' => 'Unknown (Automatic Tracker Request)',
            'mod' => 'Unknown (Automatic Tracker Request)',
            'game_id' => $gameId,
            'approved' => false,
            'requested_by' => $this->user->id,
        ]);
    }

    private function findOrCreateCargo(object $cargo, int $gameId): Cargo
    {
        // Handle cargo weight conversion
        if ($gameId === 2) {
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
            'game_id' => $gameId,
            'approved' => false,
            'requested_by' => $this->user->id,
        ]);
    }
}