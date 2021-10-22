<?php

namespace App\Http\Middleware;

use Closure;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use JsonException;
use stdClass;

class TrackerUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Return next request if not authenticated
        if (!$request->user()) {
            return $next($request);
        }

        try {
            $requestData = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $requestData = new stdClass();
        }

        // Get or create the array of users from the cache
        $users = Cache::remember('online-tracker-users', now()->addMinutes(10), function () use ($request) {
            return [['id' => $request->user()->id, 'last_activity_at' => now()]];
        });

        // Iterate over the users stored in the cache array
        foreach ($users as $key => $user) {
            // If the current iteration matches the logged-in user, unset it because it's old,
            // and we want only the last user interaction to be stored
            if ($user['id'] === $request->user()->id) {
                unset($users[$key]);
                continue;
            }

            // If the user's last activity was more than 10 minutes ago remove it
            if ($user['last_activity_at'] < now()->subMinutes(10)) {
                unset($users[$key]);
            }
        }

        // Add this last activity to the cache array
        $users[] = ['id' => $request->user()->id, 'last_activity_at' => now(), 'near' => $this->getNearbyLocation($requestData)];

        // Put this array in the cache
        Cache::put('online-tracker-users', $users, now()->addMinutes(10));

        return $next($request);
    }

    private function getNearbyLocation(object $data): string|null
    {
        // Check if game, X and Z values are set
        if (!isset($data->game->game->name, $data->truck->position->X, $data->truck->position->Z)) {
            return null;
        }

        $response = Http::get("https://api.truckyapp.com/v2/map/{$data->game->game->name}/resolve?x={$data->truck->position->X}&y={$data->truck->position->Z}");

        // Return null if the request failed
        if ($response->failed()) {
            return null;
        }

        $response = $response->collect();

        // Return null if the response has an error, or the location was not resolved
        if ($response['error'] || !$response['response']['resolved']) {
            return null;
        }

        return $response['response']['poi']['realName'];
    }
}
