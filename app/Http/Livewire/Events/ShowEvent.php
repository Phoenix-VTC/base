<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowEvent extends Component
{
    public Event $event;

    public function mount($id)
    {
        $this->event = Event::findOrFail($id);

        if (!$this->event->public_event && !$this->event->external_event && Auth::guest()) {
            return redirect(route('login'));
        }
    }

    public function render(): View
    {
        return view('livewire.events.show')->extends('layouts.events');
    }
}
