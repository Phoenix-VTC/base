<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClearUserWelcomeFields implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Find the user or fail
        $user = User::findOrFail($event->user->getAuthIdentifier());

        // Clear the user's welcome_valid_until and welcome_token fields
        $user->updateQuietly([
            'welcome_valid_until' => null,
            'welcome_token' => null,
        ]);
    }
}
