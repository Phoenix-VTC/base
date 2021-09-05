<?php

namespace App\Http\Controllers\API;

use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JsonException;
use Laravel\Sanctum\PersonalAccessToken;

class TrackerController extends Controller
{
    public const UNAUTHORIZED = 'Unauthorized';

    private User $user;

    /**
     * Handle the incoming tracker request
     *
     * @param Request $request
     * @return JsonResponse
     * @throws JsonException
     */
    public function handleRequest(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        // Check if the token is provided
        if (!$token) {
            return response()->json([
                'error' => true,
                'descriptor' => self::UNAUTHORIZED
            ]);
        }

        // Decode the token
        $token = base64_decode($token);

        // Find the Personal Access Token
        $token = PersonalAccessToken::findToken($token);

        // Check if a Personal Access Token was found
        if (!$token) {
            return response()->json([
                'error' => true,
                'descriptor' => self::UNAUTHORIZED
            ]);
        }

        // Get the user
        $this->user = $token->tokenable;

        // Decode the request content
        $data = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);

        if ($data->job->income !== 0) {
            $this->processJobData($data);
        }

        return response()->json(['error' => false]);
    }

    private function processJobData(object $data): void
    {
        $gameId = $data->game->game->id;
        $cargoDamage = round($data->job->cargo->damage / 0.01);

        // Find or create the job
        $job = Job::firstOrCreate([
            'user_id' => $this->user->id,
            'game_id' => $gameId,
            'pickup_city_id' => ($pickupCity = $this->findOrCreateCity($data->job->source->city->id, $gameId))->id,
            'destination_city_id' => ($destinationCity = $this->findOrCreateCity($data->job->destination->city->id, $gameId))->id,
            'pickup_company_id' => ($pickupCompany = $this->findOrCreateCompany($data->job->source->company->name, $gameId))->id,
            'destination_company_id' => ($destinationCompany = $this->findOrCreateCompany($data->job->destination->company->name, $gameId))->id,
            'cargo_id' => ($cargo = $this->findOrCreateCargo($data->job->cargo, $gameId))->id,
            'estimated_income' => $data->job->income,
            'total_income' => $data->job->income,
            'tracker_job' => true,
        ], [
            'started_at' => Carbon::now(),
            'load_damage' => $cargoDamage,
            'distance' => ceil($data->job->plannedDistance->km) // TODO: Test with ATS
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

    private function findOrCreateCompany(string $companyName, int $gameId): Company
    {
        if (!$companyName) {
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
        // TODO: Test with ATS
        if ($gameId === 1) {
            $weight = round($cargo->mass / 1000);
        } else {
            $weight = $cargo->mass;
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
