<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TrackerAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        // Check if the token is provided
        if (!$token) {
            return response()->json([
                'error' => true,
                'descriptor' => 'Unauthorized'
            ], 401);
        }

        // Decode the token
        $token = base64_decode($token);

        // Find the Personal Access Token
        $token = PersonalAccessToken::findToken($token);

        // Check if a Personal Access Token was found
        if (!$token) {
            return response()->json([
                'error' => true,
                'descriptor' => 'Unauthorized'
            ], 401);
        }

        // Check if the token can submit jobs
        if ($token->cant('jobs:submit')) {
            return response()->json([
                'error' => true,
                'descriptor' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }
}
