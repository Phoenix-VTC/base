<?php

namespace App\Http\Livewire\Events\Management;

use Livewire\Component;

class ShowCreate extends Component
{
    public function render()
    {
        return view('livewire.events.management.create')->extends('layouts.app');
    }
}
