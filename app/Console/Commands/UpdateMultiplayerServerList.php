<?php

namespace App\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateMultiplayerServerList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truckersmp:update-server-list-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the TruckersMP server list cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $response = Http::timeout(5)
            ->retry(3, 500)
            ->get('https://api.truckersmp.com/v2/servers');

        if ($response->failed() || ($response->successful() && $response->json()['error'] === true)) {
            $this->error('Failed to update the TruckersMP server list due to an API error. The current cached version will be used until the next attempt.');

            return;
        }

        // Update the cache, and store it forever. It will then only be replaced when this command is ran, and the API response was successful.
        Cache::forever('truckersmp_server_list', $response->json('response'));

        $this->info('Successfully updated the TruckersMP server list cache.');
    }
}
