<?php

namespace App\Console\Commands;

use App\Models\Company;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportCompaniesFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:json-import {url} {game_id} {--d|dlc=} {--m|mod=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import companies from JSON data. Read the documentation and/or code to see which fields are required in the JSON.';

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
            $companies = Http::get($this->argument('url'))
                ->throw()
                ->collect();

            $bar = $this->output->createProgressBar(count($companies));
            $bar->start();

            $companies->each(function ($company) use ($bar) {
                $this->findOrCreateCompany($company['name']);

                $bar->advance();
            });

            $bar->finish();
            $this->newLine();
            $this->alert('Company importing finished!');
        } catch (Exception $e) {
            $this->error('Something went wrong while importing the companies.');
            $this->alert($e->getMessage());

            exit;
        }
    }

    private function findOrCreateCompany(string $companyName): void
    {
        $companyModel = Company::firstOrCreate([
            'name' => $companyName,
            'game_id' => $this->argument('game_id'),
        ], [
            'dlc' => $this->option('dlc'),
            'mod' => $this->option('mod'),
        ]);

        if (!$companyModel->wasRecentlyCreated) {
            $this->line("Skipped $companyName, already exists.");
        }

        if ($companyModel->wasRecentlyCreated) {
            $this->info("$companyName has been added.");
        }
    }
}
