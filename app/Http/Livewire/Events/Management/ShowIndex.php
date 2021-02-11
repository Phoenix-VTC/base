<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndex extends Component
{
    public Collection $events;

    public function mount(): void
    {
        $this->events = Event::with('host')->get();
    }

    public function render(): View
    {
        return view('livewire.events.management.index')->extends('layouts.app');
    }
}
