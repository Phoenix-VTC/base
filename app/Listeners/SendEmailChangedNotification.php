<?php

namespace App\Listeners;

use App\Events\EmailChanged;
use App\Notifications\User\EmailChangedNotification;

class SendEmailChangedNotification
{
    /**
     * Handle the event.
     *
     * @param EmailChanged $event
     * @return void
     */
    public function handle(EmailChanged $event): void
    {
        $event->user->notify(new EmailChangedNotification());
    }
}
