<?php

namespace App\Http\Middleware\DriverApplication;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotSteamAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (session()->has('steam_user')) {
            return redirect(route('driver-application.form'));
        }

        return $next($request);
    }
}
