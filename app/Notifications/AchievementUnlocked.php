<?php

namespace App\Notifications;

use Assada\Achievements\Model\AchievementDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AchievementUnlocked extends Notification implements ShouldQueue
{
    use Queueable;

    private AchievementDetails $achievement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AchievementDetails $achievement)
    {
        $this->achievement = $achievement;
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
            'title' => 'Achievement unlocked!',
            'content' => 'You have unlocked the <b>' . $this->achievement->name . '</b> achievement!<br>Check your profile now.',
            'link' => route('profile'),
        ];
    }
}
