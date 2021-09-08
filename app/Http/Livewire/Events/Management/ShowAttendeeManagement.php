<?php

namespace App\Http\Livewire\Events\Management;

use App\Enums\Attending;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class ShowAttendeeManagement extends Component
{
    public Event $event;
    public string $user_id = '';

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id']
        ];
    }

    protected array $messages = [
        'user_id.exists' => 'Could not find a user associated with this ID.',
    ];

    public function mount($id): void
    {
        $this->event = Event::with('attendees', 'attendees.user')->findOrFail($id);
    }

    public function render(): View
    {
        return view('livewire.events.management.attendee-management')->extends('layouts.app');
    }

    public function confirmAttendance(EventAttendee $attendee): void
    {
        $attendee->attending = Attending::Yes;

        $attendee->save();

        session()->now('alert', ['type' => 'success', 'message' => 'User <b>' . $attendee->user->username . '</b> successfully marked as attending.']);
    }

    public function removeAttendance(EventAttendee $attendee): void
    {
        $attendee->delete();

        session()->now('alert', ['type' => 'success', 'message' => 'User <b>' . $attendee->user->username . '</b> successfully removed from event attendance.']);
    }

    public function addAttendee(): void
    {
        $this->validate();

        $user = User::findOrFail($this->user_id);

        // Check if the user is already marked as attending
        if ($this->event->attendees()->where('user_id', $user->id)->exists()) {
            session()->now('alert', ['type' => 'danger', 'message' => 'User <b>' . $user->username . '</b> is already marked as attending.']);

            return;
        }

        $this->event->attendees()->create([
            'user_id' => $user->id,
            'attending' => Attending::Yes
        ]);

        unset($this->user_id);

        session()->flash('alert', ['type' => 'success', 'message' => 'User <b>' . $user->username . '</b> successfully marked as attending.']);
    }

    public function hydrate(): void
    {
        $this->event = $this->event->fresh();
    }
}
