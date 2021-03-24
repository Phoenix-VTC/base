<?php

namespace App\Console\Commands;

use App\Models\City;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;

class SeedCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the cities table with the Trucky cities API';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://api.truckyapp.com/v2/map/cities/all')->getBody();

            $cities = json_decode($response, true, 512, JSON_THROW_ON_ERROR)['response'];
        } catch (GuzzleException | JsonException $e) {
            $this->error($e->getMessage());

            exit;
        }

        $this->withProgressBar($cities, function ($city) {
            $cityModel = City::firstOrCreate([
                'real_name' => $city['realName'],
                'name' => $city['in_game_id'] ?? $city['realName'],
                'country' => $city['country'],
                'dlc' => $city['dlc'],
                'mod' => $city['mod'],
                'game_id' => $this->gameNameToId($city['game']),
                'x' => $city['x'],
                'z' => $city['z'],
            ]);

            if (!$cityModel->wasRecentlyCreated) {
                $this->line('Skipped ' . $city['realName'] . ', already exists.');
            }

            if ($cityModel->wasRecentlyCreated) {
                $this->info($cityModel->real_name . ' has been added.');
            }
        });

        $this->newLine();
        $this->info('Seeding finished!');
    }

    private function gameNameToId($name): ?int
    {
        if ($name === 'ets2') {
            return 1;
        }

        if ($name === 'ats') {
            return 2;
        }

        return null;
    }
}
