<?php

namespace App\Http\Livewire\DriverApplication;

use Livewire\Component;

class ShowAuthPage extends Component
{
    public function render()
    {
        return view('livewire.driver-application.auth')->extends('layouts.driver-application');
    }
}
