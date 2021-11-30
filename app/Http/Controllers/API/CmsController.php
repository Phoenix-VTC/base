<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use RestCord\DiscordClient;
use Spatie\Permission\Models\Role;

class CmsController extends Controller
{
    public function statistics(): JsonResponse
    {
        $statistics = Cache::remember('users', now()->addDay(), function () {
            $statistics = [];

            $statistics['communityMembers'] = $this->calculateCommunityMembers();

            $statistics['eventsAttended'] = $this->calculateEventsAttended();

            $statistics['activeDrivers'] = $this->calculateActiveDrivers();

            $statistics['staffMembers'] = $this->calculateStaffMembers();

            return $statistics;
        });

        return response()->json($statistics);
    }

    private function calculateCommunityMembers(): int|null
    {
        try {
            // Create a new Discord client session
            $client = new DiscordClient(['token' => config('services.discord.token')]);

            // Get a list of guild members
            $memberList = $client->guild->listGuildMembers([
                'guild.id' => (int)config('services.discord.server-id'),
                'limit' => 1000,
            ]);
        } catch (Exception) {
            return null;
        }

        return count($memberList);
    }

    private function calculateEventsAttended(): int
    {
        return Event::getTotalEventsAttended();
    }

    private function calculateActiveDrivers(): int
    {
        return User::count();
    }

    private function calculateStaffMembers(): int
    {
        return Role::findByName('phoenix staff')->users()->count();
    }
}
