<?php

namespace App\Console\Commands;

use App\Models\Company;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use JsonException;

class ImportCompaniesFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:json-import {url} {game_id}';

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

        $client = new Client();

        try {
            $response = $client->request('GET', $this->argument('url'))->getBody();

            $companies = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleException | JsonException $e) {
            $this->error($e->getMessage());

            exit;
        }

        $bar = $this->output->createProgressBar(count($companies));
        $bar->start();

        foreach ($companies as $key => $company) {
            // Find the company by name or create it
            $companyModel = Company::firstOrCreate(
                [
                    'name' => $key
                ],
                [
                    'category' => Str::limit($company['Category'], 250),
                    'specialization' => $company['Specialization'],
                    'dlc' => str_replace(' / ', ', ', $company['Required Expansion']),
                    'game_id' => $this->argument('game_id'),
                ]
            );

            if (!$companyModel->wasRecentlyCreated) {
                $this->line("Skipped $key, already exists.");
            }

            if ($companyModel->wasRecentlyCreated) {
                $this->info("$key has been added.");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Company importing finished!');
    }
}
