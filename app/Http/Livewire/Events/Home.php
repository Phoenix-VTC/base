<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Home extends Component
{
    public Collection $events;
    public Collection $featured_events;
    public Collection $upcoming_events;

    public function mount(): void
    {
        $this->events = Event::with('host')
            ->where('start_date', '>=', Carbon::now()->toDateTimeString())
            ->get();

        $this->featured_events = $this->events
            ->where('published', true)
            ->where('featured', true)
            ->sortBy('start_date')
            ->take(6);

        $this->upcoming_events = $this->events
            ->where('published', true)
            ->sortBy('start_date')
            ->take(6);
    }

    public function render(): View
    {
        return view('livewire.events.home')->extends('layouts.events');
    }
}
