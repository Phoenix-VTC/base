<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanSubmitJobs
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
        if (! $request->user()->tokenCan('jobs:submit')) {
            abort(403, 'This token does not have permission to submit jobs.');
        }

        return $next($request);
    }
}
