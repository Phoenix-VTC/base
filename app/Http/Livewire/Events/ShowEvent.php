<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;

class ShowEvent extends Component
{
    public Event $event;

    public function mount($id): void
    {
        $this->event = Event::findOrFail($id);
    }

    public function render(): View
    {
        return view('livewire.events.show')->extends('layouts.events');
    }
}
