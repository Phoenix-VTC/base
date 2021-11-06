<?php

namespace App\Console\Commands;

use App\Models\City;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportCitiesFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:json-import {url} {game_id} {--d|dlc=} {--m|mod=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cities from JSON data. Read the documentation and/or code to see which fields are required in the JSON.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!filter_var($this->argument('url'), FILTER_VALIDATE_URL)) {
            $this->error('The provided URL is invalid.');
            exit;
        }

        // Check if the Game ID is either 1 or 2
        if (!in_array($this->argument('game_id'), [1, 2], false)) {
            $this->error('The Game ID must be either 1 (ETS2) or 2 (ATS).');
            exit;
        }

        try {
            $cities = Http::get($this->argument('url'))
                ->throw()
                ->collect();

            $bar = $this->output->createProgressBar(count($cities));
            $bar->start();

            $cities->each(function ($city) use ($bar) {
                if (array_key_exists('localizedNames', $city)) {
                    $cityNameCount = count($city['localizedNames']);
                    $bar->setMaxSteps($bar->getMaxSteps() + $cityNameCount);

                    foreach($city['localizedNames'] as $cityName) {
                        $this->findOrCreateCity($city['id'], $cityName, $city['countryId']);
                    }

                    $bar->advance($cityNameCount);
                } else {
                    $this->findOrCreateCity($city['id'], $city['defaultName'], $city['countryId']);

                    $bar->advance();
                }
            });

            $bar->finish();
            $this->newLine();
            $this->alert('City importing finished!');
        } catch (Exception $e) {
            $this->error('Something went wrong while importing the cities.');
            $this->alert($e->getMessage());

            exit;
        }
    }

    private function findOrCreateCity(string $cityId, string $cityName, string $countryId): void
    {
        $cityModel = City::firstOrCreate([
            'name' => $cityId,
            'real_name' => $cityName,
            'country' => ucwords($countryId),
            'game_id' => $this->argument('game_id'),
        ], [
            'dlc' => $this->option('dlc'),
            'mod' => $this->option('mod'),
        ]);

        if (!$cityModel->wasRecentlyCreated) {
            $this->line("Skipped $cityName, already exists.");
        }

        if ($cityModel->wasRecentlyCreated) {
            $this->info("$cityName has been added.");
        }
    }
}
