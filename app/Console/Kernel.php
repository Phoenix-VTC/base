<?php

namespace App\Console;

use App\Console\Commands\UpdateMultiplayerServerList;
use App\Jobs\CheckDriverBans;
use App\Jobs\CheckDriverVTC;
use App\Jobs\VacationRequests\UpdateDiscordRoles;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cloudflare:reload')->daily();

        $schedule->job(new CheckDriverBans)->daily();

        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->job(new CheckDriverVTC)->dailyAt('23:00');

        $schedule->job(new UpdateDiscordRoles)->daily();

        $schedule->job(new UpdateMultiplayerServerList)->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
