<?php

namespace App\Listeners;

use App\Notifications\AchievementUnlocked;
use Assada\Achievements\Event\Unlocked;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAchievementUnlockedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param Unlocked $event
     * @return void
     */
    public function handle(Unlocked $event)
    {
        $event->progress->achiever->notify(new AchievementUnlocked($event->progress->details));
    }
}
