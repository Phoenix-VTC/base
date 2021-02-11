<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Home extends Component
{
    public Collection $featured_events;

    public function mount(): void
    {
        $this->featured_events = Event::getFeaturedEvents();
    }

    public function render(): View
    {
        return view('livewire.events.home')->extends('layouts.events');
    }
}
