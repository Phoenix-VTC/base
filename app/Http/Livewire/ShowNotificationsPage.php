<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowNotificationsPage extends Component
{
    public function render()
    {
        return view('livewire.notifications-page')->extends('layouts.app');
    }
}
