<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->name('api.')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->domain(config('app.url'))
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->domain(config('app.apply_url'))
                ->name('driver-application.')
                ->group(base_path('routes/driver-application.php'));

            Route::middleware('web')
                ->domain(config('app.events_url'))
                ->name('events.')
                ->group(base_path('routes/events.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
