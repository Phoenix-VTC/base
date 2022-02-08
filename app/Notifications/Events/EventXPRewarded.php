<?php

namespace App\Notifications\Events;

use App\Models\EventAttendee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventXPRewarded extends Notification implements ShouldQueue
{
    use Queueable;

    private EventAttendee $attendee;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EventAttendee $attendee)
    {
        $this->attendee = $attendee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => 'Event XP rewarded!',
            'content' => 'Your Event XP for "<b>'.$this->attendee->event->name.'</b>" has been rewarded!',
            'link' => route('my-wallet'),
        ];
    }
}
