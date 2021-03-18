<?php

namespace App\Jobs\Events;

use App\Models\Event;
use App\Models\User;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
     */
    public function handle(): void
    {
        foreach ($this->attendees as $attendee) {
            $user = $attendee->user;

            $wallet = $this->findOrCreateWallet($user);

            $wallet->deposit($this->event->points, ['event_name' => $this->event->name]);
        }
    }

    public function findOrCreateWallet(User $user): Wallet
    {
        if (!$user->hasWallet('event-xp')) {
            $user->createWallet([
                'name' => 'Event XP',
                'slug' => 'event-xp',
            ]);
        }

        return $user->getWalletOrFail('event-xp');
    }
}
