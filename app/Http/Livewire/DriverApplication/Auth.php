<?php

namespace App\Http\Livewire\DriverApplication;

use Livewire\Component;

class Auth extends Component
{
    public function render()
    {
        return view('livewire.driver-application.auth')->extends('layouts.driver-application');
    }
}
