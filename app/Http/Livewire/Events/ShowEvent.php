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
        $this->event = Event::with('host', 'attendees', 'attendees.user')
            ->where('published', true)
            ->findOrFail($id);

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
            session()->now('alert', ['type' => 'danger', 'message' => "Slow down! Please wait another $exception->secondsUntilAvailable seconds."]);
            return;
        }

        if (!$this->event->is_past && Auth::check()) {
            EventAttendee::updateOrCreate(
                ['user_id' => Auth::id(), 'event_id' => $this->event->id],
                ['attending' => Attending::Yes]
            );

            session()->now('alert', ['type' => 'success', 'message' => 'Attendance marked as <strong>attending</strong>.']);
        }
    }

    public function markAsMaybeAttending(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            session()->now('alert', ['type' => 'danger', 'message' => "Slow down! Please wait another $exception->secondsUntilAvailable seconds."]);
            return;
        }

        if (!$this->event->is_past && Auth::check()) {
            EventAttendee::updateOrCreate(
                ['user_id' => Auth::id(), 'event_id' => $this->event->id],
                ['attending' => Attending::Maybe]
            );

            session()->now('alert', ['type' => 'success', 'message' => 'Attendance marked as <strong>not sure</strong>.']);
        }
    }

    public function markAsNotAttending(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            session()->now('alert', ['type' => 'danger', 'message' => "Slow down! Please wait another $exception->secondsUntilAvailable seconds."]);
            return;
        }

        if (!$this->event->is_past && Auth::check()) {
            $event_attendee = EventAttendee::where('user_id', Auth::id())
                ->where('event_id', $this->event->id)
                ->first();

            if ($event_attendee) {
                $event_attendee->delete();
            }

            session()->now('alert', ['type' => 'success', 'message' => 'Attendance marked as <strong>not attending</strong>.']);
        }
    }

    public function hydrate(): void
    {
        $this->event = $this->event->fresh();
    }
}
