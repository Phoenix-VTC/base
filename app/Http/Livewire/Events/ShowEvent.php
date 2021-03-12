<?php

namespace App\Http\Livewire\Events;

use App\Enums\Attending;
use App\Models\Event;
use App\Models\EventAttendee;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowEvent extends Component
{
    use WithRateLimiting;

    public Event $event;

    public function mount($id)
    {
        $this->event = Event::with('host', 'attendees', 'attendees.user')->findOrFail($id);

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
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            session()->flash('alert', ['type' => 'danger', 'message' => "Slow down! Please wait another $exception->secondsUntilAvailable seconds."]);
            return;
        }

        if (Auth::check()) {
            EventAttendee::updateOrCreate(
                ['user_id' => Auth::id(), 'event_id' => $this->event->id],
                ['attending' => Attending::Yes]
            );
        }
    }

    public function markAsMaybeAttending(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            session()->flash('alert', ['type' => 'danger', 'message' => "Slow down! Please wait another $exception->secondsUntilAvailable seconds."]);
            return;
        }

        if (Auth::check()) {
            EventAttendee::updateOrCreate(
                ['user_id' => Auth::id(), 'event_id' => $this->event->id],
                ['attending' => Attending::Maybe]
            );
        }
    }

    public function markAsNotAttending(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            session()->flash('alert', ['type' => 'danger', 'message' => "Slow down! Please wait another $exception->secondsUntilAvailable seconds."]);
            return;
        }

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
