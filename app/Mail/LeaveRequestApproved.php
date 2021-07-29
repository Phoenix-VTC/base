<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestApproved extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public User $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): LeaveRequestApproved
    {
        return $this->subject('Your request to leave Phoenix has been approved')
            ->markdown('emails.leave-request-approved');
    }
}
