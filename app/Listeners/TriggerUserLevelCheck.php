<?php

namespace App\Listeners;

use App\Events\UserPointsChanged;
use App\Jobs\CheckUserLevel;
use Illuminate\Contracts\Queue\ShouldQueue;

class TriggerUserLevelCheck implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param UserPointsChanged $event
     * @return void
     */
    public function handle(UserPointsChanged $event): void
    {
        CheckUserLevel::dispatch($event->user);
    }
}
