<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class OnlineUserController extends Controller
{
    public function onlineTrackerUsers(): array
    {
        return $this->getOnlineUsers(true);
    }

    private function getOnlineUsers(bool $tracker = false): array
    {
        if ($tracker) {
            $cacheKey = 'online-tracker-users';
        } else {
            $cacheKey = 'online-users';
        }

        // Get the array of users
        $users = Cache::get($cacheKey);

        if (! $users) {
            return [];
        }

        // Add the array to a collection, so you can pluck the IDs
        $onlineUsers = collect($users);

        // Get all users by ID from the DB (1 very quick query)
        $dbUsers = User::find($onlineUsers->pluck('id')->toArray());

        // Prepare the return array
        $displayUsers = [];

        // Iterate over the retrieved DB users
        foreach ($dbUsers as $user) {
            // Append the data to the return array
            $displayUsers[] = [
                'id' => $user->id,
                'username' => $user->username,
                'profile_picture' => $user->profile_picture,
                'near' => $onlineUsers->firstWhere('id', $user->id)['near'],
            ];
        }

        return $displayUsers;
    }
}
