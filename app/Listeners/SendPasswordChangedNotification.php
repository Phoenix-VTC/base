<?php

namespace App\Listeners;

use App\Events\PasswordChanged;
use App\Notifications\User\PasswordChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordChangedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param PasswordChanged $event
     * @return void
     */
    public function handle(PasswordChanged $event): void
    {
        $event->user->notify(new PasswordChangedNotification());
    }
}
