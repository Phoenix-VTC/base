<?php

namespace App\Actions\Game;

use Cache;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GetNearestCity
{
    private string $game;
    private bool $promods;

    /**
     * Attempt to find the nearest point of interest with the given X and Y coordinates.
     *
     * @param int $x
     * @param int $y
     * @param string $game
     * @param bool $promods
     * @return array|null
     */
    public function execute(int $x, int $y, string $game, bool $promods): ?array
    {
        $this->game = $game;
        $this->promods = $promods;

        // Get the correct JSON URL for the game with/without ProMods
        if (strtolower($game) === 'ets2' && $promods === false) {
            $url = 'https://map.truckersmp.com/locations_ets2.min.json';
        } elseif (strtolower($game) === 'ets2' && $promods === true) {
            $url = 'https://map.truckersmp.com/locations_promods.min.json';
        } elseif (strtolower($game) === 'ats') {
            $url = 'https://map.truckersmp.com/locations_ats.min.json';
        } else {
            return null;
        }

        $cities = $this->getCities($url);

        if ($cities->isEmpty()) {
            return null;
        }

        return $this->findNearestCity($x, $y, $cities);
    }

    private function getCities(string $locationsUrl): Collection
    {
        return Cache::remember($this->getCacheName(), now()->addQuarter(), function () use ($locationsUrl) {
            // Try to get all POIs from the TruckersMP locations JSON file
            try {
                $locations = Http::timeout(3)
                ->retry(3, 200)
                    ->get($locationsUrl)
                    ->throw()
                    ->collect();
            } catch (HttpClientException) {
                return null;
            }

            $cities = [];

            // Loop through all countries
            $locations->where('type', 'country')->each(function ($country) use (&$cities) {
                // Collect the country's cities
                $countryCities = collect($country['pois'])
                    ->where('type', 'city');

                // Loop through all cities
                $countryCities->each(function ($city) use (&$cities, $country) {
                    // Add the country name to the city
                    $city['country'] = $country['name'];

                    // Rename `name` to `city`
                    $city['city'] = $city['name'];
                    unset($city['name']);

                    // Add the city to the cities array
                    $cities[] = Arr::except($city, ['pois', 'type']);
                });
            });

            return collect($cities);
        });
    }

    private function findNearestCity(int $x, int $y, Collection $cities)
    {
        // Every city in $cities has an X and Y coordinate, so we can use that to calculate the distance
        $cities = $cities->map(function ($city) use ($x, $y) {
            // GitHub CoPilot wrote the below line for me. I have no idea how it works, but it works
            $distance = sqrt((($x - $city['x']) ** 2) + (($y - $city['y']) ** 2));
            $city['distance_to_city'] = round($distance);

            return $city;
        });

        // Sort the cities by distance
        $cities = $cities->sortBy('distance_to_city');

        // Return the first city
        return $cities->first();
    }

    private function getCacheName(): string
    {
        return 'truckersmp_cities_' . strtolower($this->game) . ($this->promods ? '_promods' : '');
    }
}
