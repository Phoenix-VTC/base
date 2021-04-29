<?php

namespace App\Console\Commands;

use App\Models\Cargo;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;

class ImportCargosFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargos:json-import {url} {game_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cargos from JSON data. Read the documentation and/or code to see which fields are required in the JSON.';

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

        $client = new Client();

        try {
            $response = $client->request('GET', $this->argument('url'))->getBody();

            $cargos = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleException | JsonException $e) {
            $this->error($e->getMessage());

            exit;
        }

        $bar = $this->output->createProgressBar(count($cargos));
        $bar->start();

        foreach ($cargos as $key => $cargo) {
            // Find the cargo by name or create it
            $cargoModel = Cargo::firstOrCreate(
                [
                    'name' => $key,
                    'game_id' => $this->argument('game_id'),
                ],
                [
                    'dlc' => $cargo[0]['DLC'],
                    'weight' => $this->convertWeightToInt($cargo[0]['Weight (t) *'] ?? $cargo[0]['Weight (lb) *']) ?: null,
                ]
            );

            if (!$cargoModel->wasRecentlyCreated) {
                $this->line("Skipped $key, already exists.");
            }

            if ($cargoModel->wasRecentlyCreated) {
                $this->info("$key has been added.");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Cargo importing finished!');
    }

    /**
     * Convert a weight value with multiple values to the highest value
     *
     * Example: "17-21" will be converted to "21"
     *
     * @param $weight
     * @return int|string|null
     */
    public function convertWeightToInt($weight)
    {
        // Remove any decimal separators
        $weight = str_replace(',', '', $weight);

        // Return the weight if there is no -
        if (!str_contains($weight, '-')) {
            return $weight;
        }

        // Return the value after -, so the highest weight
        return substr($weight, strpos($weight, "-") + 1);
    }
}
