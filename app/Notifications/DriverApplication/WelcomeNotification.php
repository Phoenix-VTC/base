<?php

namespace App\Notifications\DriverApplication;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends \Spatie\WelcomeNotification\WelcomeNotification implements ShouldQueue
{
    use Queueable;

    public $validUntil;
    public $user;

    public function __construct(User $user, Carbon $validUntil)
    {
        $this->validUntil = $validUntil;

        $this->user = $user;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function buildWelcomeNotificationMessage(): MailMessage
    {
        return (new MailMessage)
            ->markdown('emails.driver-application.application-accepted', ['user' => $this->user, 'showWelcomeFormUrl' => $this->showWelcomeFormUrl, 'validUntil' => $this->validUntil])
            ->subject('Application Accepted!');
    }
}
