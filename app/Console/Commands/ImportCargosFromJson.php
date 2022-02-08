<?php

namespace App\Console\Commands;

use App\Models\Cargo;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportCargosFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargos:json-import {url} {game_id} {--d|dlc=} {--m|mod=}';

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
        if (! filter_var($this->argument('url'), FILTER_VALIDATE_URL)) {
            $this->error('The provided URL is invalid.');
            exit;
        }

        // Check if the Game ID is either 1 or 2
        if (! in_array($this->argument('game_id'), [1, 2], false)) {
            $this->error('The Game ID must be either 1 (ETS2) or 2 (ATS).');
            exit;
        }

        try {
            $cargos = Http::get($this->argument('url'))
                ->throw()
                ->collect();

            $bar = $this->output->createProgressBar(count($cargos));
            $bar->start();

            $cargos->each(function ($cargo) use ($bar) {
                $cargoNameCount = count($cargo['localizedNames']);

                $bar->setMaxSteps($bar->getMaxSteps() + $cargoNameCount);

                foreach ($cargo['localizedNames'] as $cargoName) {
                    $this->findOrCreateCargo($cargoName);
                }

                $bar->advance($cargoNameCount);
            });

            $bar->finish();
            $this->newLine();
            $this->alert('Cargo importing finished!');
        } catch (Exception $e) {
            $this->error('Something went wrong while importing the cargos.');
            $this->alert($e->getMessage());

            exit;
        }
    }

    private function findOrCreateCargo(string $cargoName): void
    {
        $cargoModel = Cargo::firstOrCreate([
            'name' => $cargoName,
            'game_id' => $this->argument('game_id'),
        ], [
            'dlc' => $this->option('dlc'),
            'mod' => $this->option('mod'),
        ]);

        if (! $cargoModel->wasRecentlyCreated) {
            $this->line("Skipped $cargoName, already exists.");
        }

        if ($cargoModel->wasRecentlyCreated) {
            $this->info("$cargoName has been added.");
        }
    }
}
