<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
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
        // For whatever reason trucky blocks the default guzzle user-agent
        $request = Http::withHeaders(['user-agent' => 'seeder'])
            ->get('https://api.truckyapp.com/v2/map/cities/all');

        if (! $request->ok() || ! $request['response']) {
            $this->error('Failed to fetch cities from Trucky API');

            exit;
        }

        $this->withProgressBar($request['response'], function ($city) {
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

            if (! $cityModel->wasRecentlyCreated) {
                $this->line('Skipped '.$city['realName'].', already exists.');
            }

            if ($cityModel->wasRecentlyCreated) {
                $this->info($cityModel->real_name.' has been added.');
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
