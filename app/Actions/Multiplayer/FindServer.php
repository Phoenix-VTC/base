<?php

namespace App\Actions\Multiplayer;

use Illuminate\Support\Facades\Cache;

class FindServer
{
    /**
     * Attempt to find a TruckersMP server by the given ID.
     *
     * @param int $serverId
     * @return array|null
     */
    public function execute(int $serverId): ?array
    {
        // Get the cached server info from the TruckersMP API
        $servers = Cache::get('truckersmp_server_list', []);

        $servers = collect($servers);

        // Try to find the server, and return it
        return $servers->firstWhere('mapid', $serverId);
    }
}
