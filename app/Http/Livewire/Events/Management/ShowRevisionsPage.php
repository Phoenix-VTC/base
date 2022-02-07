<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowRevisionsPage extends Component
{
    use AuthorizesRequests;

    public Event $event;

    public function mount(): void
    {
        $this->authorize('update', $this->event);
    }

    public function render()
    {
        return view('livewire.events.management.revisions-page')->extends('layouts.app');
    }
}
