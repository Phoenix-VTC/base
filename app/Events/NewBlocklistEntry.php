<?php

namespace App\Events;

use App\Models\Blocklist;

class NewBlocklistEntry
{
    public Blocklist $blocklist;

    /**
     * Create a new event instance.
     *
     * @param Blocklist $blocklist
     * @return void
     */
    public function __construct(Blocklist $blocklist)
    {
        $this->blocklist = $blocklist;
    }
}
