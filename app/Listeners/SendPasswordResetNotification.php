<?php

namespace App\Listeners;

use App\Notifications\User\PasswordResetNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param PasswordReset $event
     * @return void
     */
    public function handle(PasswordReset $event): void
    {
        $event->user->notify(new PasswordResetNotification());
    }
}
