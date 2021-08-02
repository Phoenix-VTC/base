<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangedNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Account activity: Email changed')
            ->greeting('Did you change your email?')
            ->line('We noticed the email for your PhoenixBase account was recently changed. If this was you, you can safely disregard this email.')
            ->line('If this wasn\'t you, please contact us as soon as possible.');
    }
}
