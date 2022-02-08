<?php

namespace App\Events;

use App\Models\User;

class UserInBlocklistAuthenticated
{
    public User $user;

    public string $triggerValue;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $triggerValue)
    {
        $this->user = $user;
        $this->triggerValue = $triggerValue;
    }
}
