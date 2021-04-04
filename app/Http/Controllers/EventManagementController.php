<?php

namespace App\Http\Controllers;

use App\Jobs\Events\ProcessUserRewards;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;

class EventManagementController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage events']);
    }

    public function rewardEventXP(Event $event): RedirectResponse
    {
        if ($event->completed) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => 'This event is already completed.']);
        }

        if (!$event->is_past) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => 'Please wait until the event is finished before rewarding Event XP.']);
        }

        ProcessUserRewards::dispatch($event);

        $event->completed = true;
        $event->save();

        session()->flash('alert', ['type' => 'success', 'message' => 'Successfully submitted rewards for <b>' . $event->name . '</b>.']);

        return redirect()->route('event-management.index');
    }

    public function delete(Event $event): RedirectResponse
    {
        $event->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Event deleted successfully!']);

        return redirect()->route('event-management.index');
    }
}
