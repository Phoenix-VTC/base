<?php

namespace App\Http\Livewire\DriverApplication;

use Livewire\Component;

class ShowBlockedPage extends Component
{
    public function mount(): void
    {
        /*
         * Forget the TruckersMP and Steam session data, so that the user can only view this page once
         * It also uses the SteamAuthenticated middleware, so that you can only view this route if you're authenticated
         */
        session()->forget('steam_user');
        session()->forget('truckersmp_user');
    }

    public function render()
    {
        return view('livewire.driver-application.blocked')->extends('layouts.driver-application');
    }
}
