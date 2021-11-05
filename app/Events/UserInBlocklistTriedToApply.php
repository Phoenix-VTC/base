<?php

namespace App\Events;

class UserInBlocklistTriedToApply
{
    public string $triggerValue;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $triggerValue)
    {
        $this->triggerValue = $triggerValue;
    }
}
