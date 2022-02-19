<?php

namespace App\Actions\Multiplayer;

use Cache;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class FindPlayer
{
    /**
     * Attempt to find a player online on TruckersMP by their TruckersMP ID.
     *
     * @param int $truckersmpId
     * @return array|null
     */
    public function execute(int $truckersmpId): ?array
    {
        return Cache::remember('truckersmp_player_' . $truckersmpId, now()->addMinute(), function () use ($truckersmpId) {
            // Try to get the player info from the ETS2MAP API
            try {
                $response = Http::timeout(3)
                    ->retry(3, 200)
                    ->get('https://tracker.ets2map.com/v3/playersearch', [
                        'string' => $truckersmpId,
                    ])
                    ->throw()
                    ->json();
            } catch (HttpClientException) {
                return null;
            }

            // Check if the request was successful
            if ($response['Success'] === false) {
                return null;
            }

            // Check if any player was found
            if (!$response['Data']) {
                return null;
            }

            // If multiple players were found, search for the TruckersMP ID
            if (count($response['Data']) > 1) {
                return collect($response['Data'])->firstWhere('MpId', $truckersmpId);
            }

            // If only one player was found, return it
            return $response['Data'][0];
        });
    }
}
