<?php

namespace App\Jobs\Events;

use App\Achievements\EventAttendedChain;
use App\Achievements\EventXPStonks;
use App\Actions\Wallet\FindOrCreateWallet;
use App\Events\UserPointsChanged;
use App\Models\Event;
use App\Models\User;
use App\Notifications\Events\EventXPRewarded;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessUserRewards implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Event $event;
    public Collection $attendees;

    /**
     * Create a new job instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->attendees = $this->event->attendees;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        foreach ($this->attendees as $attendee) {
            $user = $attendee->user;

            // Reward the Event XP
            $wallet = (new FindOrCreateWallet())->execute($attendee->user, 'Event XP');
            $wallet->deposit($this->event->points, ['event_name' => $this->event->name]);

            // Handle the achievements
            $this->handleAchievements($user);

            // Notify the user about the XP reward
            $user->notify(new EventXPRewarded($attendee));

            event(new UserPointsChanged($attendee->user));
        }
    }

    private function handleAchievements(User $user): void
    {
        $user->addProgress(new EventAttendedChain(), 1);

        if ($this->event->points === 500) {
            $user->unlock(new EventXPStonks());
        }
    }
}
