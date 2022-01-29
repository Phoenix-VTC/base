<?php

namespace App\Http\Livewire\Events\Components;

use App\Models\Event;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Redirector;

class EventsCalendar extends LivewireCalendar
{
    public function events(): Collection
    {
        return Event::all()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'description' => Str::words(strip_tags($event->description), 5),
                    'date' => $event->start_date,
                ];
            });
    }

    public function onEventClick($eventId): RedirectResponse|Redirector
    {
        return redirect()->route('event-management.edit', $eventId);
    }
}
