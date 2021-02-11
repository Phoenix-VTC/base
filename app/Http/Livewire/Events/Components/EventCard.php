<?php

namespace App\Http\Livewire\Events\Components;

use Livewire\Component;

class EventCard extends Component
{
    public $event;

    public function render()
    {
        return view('livewire.events.components.event-card');
    }
}
