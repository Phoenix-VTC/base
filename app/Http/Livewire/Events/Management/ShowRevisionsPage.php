<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Livewire\Component;

class ShowRevisionsPage extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.events.management.revisions-page')->extends('layouts.app');
    }
}
