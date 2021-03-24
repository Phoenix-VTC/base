<?php

namespace App\Http\Livewire\Events\Management;

use App\Enums\Attending;
use App\Jobs\Events\ProcessUserRewards;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class ShowAttendeeManagement extends Component
{
    public Event $event;
    public string $username = '';

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'exists:users']
        ];
    }

    protected array $messages = [
        'username.exists' => 'A user with this username does not exist.',
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

        session()->flash('alert', ['type' => 'success', 'message' => 'User <b>' . $attendee->user->username . '</b> successfully marked as attending.']);
    }

    public function removeAttendance(EventAttendee $attendee): void
    {
        $attendee->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'User <b>' . $attendee->user->username . '</b> successfully removed from event attendance.']);
    }

    public function addAttendee(): void
    {
        $this->validate();

        $user = User::where('username', $this->username)->firstOrFail();

        $this->event->attendees()->create([
            'user_id' => $user->id,
            'attending' => Attending::Yes
        ]);

        unset($this->username);

        session()->flash('alert', ['type' => 'success', 'message' => 'User <b>' . $user->username . '</b> successfully marked as attending.']);
    }

    public function submitRewards()
    {
        if ($this->event->completed) {
           return session()->flash('alert', ['type' => 'danger', 'message' => 'This event is already completed.']);
        }

        if (!$this->event->is_past) {
            return session()->flash('alert', ['type' => 'danger', 'message' => 'Please wait until the event is finished before rewarding Event XP.']);
        }

        ProcessUserRewards::dispatch($this->event);

        $this->event->completed = true;
        $this->event->save();

        session()->flash('alert', ['type' => 'success', 'message' => 'Successfully submitted rewards for <b>' . $this->event->name . '</b>.']);

        return redirect(route('event-management.index'));
    }

    public function hydrate(): void
    {
        $this->event = $this->event->fresh();
    }
}
