<?php

namespace App\Http\Livewire\Events;

use App\Enums\Attending;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowEvent extends Component
{
    public Event $event;

    public function mount($id)
    {
        $this->event = Event::with('attendees', 'attendees.user')->findOrFail($id);

        if (!$this->event->public_event && !$this->event->external_event && Auth::guest()) {
            return redirect(route('login'));
        }
    }

    public function render(): View
    {
        return view('livewire.events.show')->extends('layouts.events');
    }

    public function markAsAttending(): void
    {
        if (Auth::check()) {
            EventAttendee::updateOrCreate(
                ['user_id' => Auth::id(), 'event_id' => $this->event->id],
                ['attending' => Attending::Yes]
            );
        }
    }

    public function markAsMaybeAttending(): void
    {
        if (Auth::check()) {
            EventAttendee::updateOrCreate(
                ['user_id' => Auth::id(), 'event_id' => $this->event->id],
                ['attending' => Attending::Maybe]
            );
        }
    }

    public function markAsNotAttending(): void
    {
        if (Auth::check()) {
            EventAttendee::where('user_id', Auth::id())
                ->where('event_id', $this->event->id)
                ->firstOrFail()
                ->delete();
        }
    }

    public function hydrate(): void
    {
        $this->event = $this->event->fresh();
    }
}
