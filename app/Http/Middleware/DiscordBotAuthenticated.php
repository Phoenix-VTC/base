<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DiscordBotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = config('app.discord-bot-api-token', '');

        if ($request->header('token') !== $token) {
            return response()->json([
                'message' => 'Incorrect token.'
            ], 401);
        }

        return $next($request);
    }
}
