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
use Laravel\Sanctum\PersonalAccessToken;

class TrackerController extends Controller
{
    const UNAUTHORIZED = 'Unauthorized';

    private User $user;

    /**
     * Handle the incoming tracker request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function handleRequest(Request $request): JsonResponse
    {
        $token = $request->header('x-userpassword');

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
        $data = json_decode($request->getContent());

//        ray($data);

        if ($data->Job->Income !== 0) {
            $this->processJobData($data);
        }

        return response()->json(['error' => false]);
    }

    private function processJobData(object $data): void
    {
        if ($data->Game->GameName === 'ETS2') {
            $gameId = 1;
        } else {
            $gameId = 2;
        }

        // Find or create the job
        $job = Job::firstOrCreate([
            'user_id' => $this->user->id,
            'game_id' => $gameId,
            'pickup_city_id' => ($pickupCity = $this->findOrCreateCity($data->Job->SourceCity, $gameId))->id,
            'destination_city_id' => ($destinationCity = $this->findOrCreateCity($data->Job->DestinationCity, $gameId))->id,
            'pickup_company_id' => ($pickupCompany = $this->findOrCreateCompany($data->Job->SourceCompany, $gameId))->id,
            'destination_company_id' => ($destinationCompany = $this->findOrCreateCompany($data->Job->DestinationCompany, $gameId))->id,
            'cargo_id' => ($cargo = $this->findOrCreateCargo($data->Cargo, $gameId))->id
        ], [
            'started_at' => Carbon::now(),
            'load_damage' => $data->JobEvent->CargoDamage,
            'estimated_income' => $data->Job->Income,
            'total_income' => $data->Job->Income,
            'distance' => ceil($data->JobEvent->Distance / 1000) // TODO: Test with ATS
        ]);

        // Set the job to PendingVerification if a city/company/cargo was recently created
        if ($pickupCity->wasRecentlyCreated || $destinationCity->wasRecentlyCreated || $pickupCompany->wasRecentlyCreated || $destinationCompany->wasRecentlyCreated || $cargo->wasRecentlyCreated) {
            $job->update([
                'status' => JobStatus::PendingVerification
            ]);
        }

        // Update the cargo damage & distance if the job wasn't recently created
        if (!$job->wasRecentlyCreated) {
            $job->update([
                'load_damage' => $data->JobEvent->CargoDamage,
                'distance' => ceil($data->JobEvent->Distance / 1000) // TODO: Test with ATS
            ]);
        }

        // Add finished_at if job is finished or delivered
        if ($data->JobEvent->JobFinished || $data->JobEvent->JobDelivered) {
            $job->update([
                'finished_at' => Carbon::now()
            ]);
        }

        // Delete job if cancelled
        if ($data->JobEvent->JobCancelled) {
            $job->delete();
        }
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

    private function findOrCreateCompany(string $sourceCompany, int $gameId): Company
    {
        return Company::firstOrCreate([
            'name' => $sourceCompany,
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
            $weight = round($cargo->Mass / 1000);
        } else {
            $weight = $cargo->Mass;
        }

        return Cargo::firstOrCreate([
            'name' => $cargo->Cargo,
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
