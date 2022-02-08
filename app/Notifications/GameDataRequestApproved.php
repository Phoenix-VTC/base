<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class GameDataRequestApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $game_data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($game_data)
    {
        $this->game_data = $game_data;
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
        $name = str_replace('_', ' ', $this->game_data['name']);
        $name = Str::title($name);

        return [
            'title' => 'Game data request approved',
            'content' => 'Your game data request with the name "'.$name.'" has been approved!',
        ];
    }
}
