<?php

namespace App\Http\Middleware\DriverApplication;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SteamAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('steam_user')) {
            return redirect(route('driver-application.authenticate'));
        }

        return $next($request);
    }
}
