<?php

namespace App\Mail\DriverApplication;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationAccepted extends Mailable
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public User $user;

    /**
     * The token instance.
     *
     * @var string
     */
    public string $token;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ApplicationAccepted
    {
        return $this->markdown('emails.driver-application.application-accepted');
    }
}
