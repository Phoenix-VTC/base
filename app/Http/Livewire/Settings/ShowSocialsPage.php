<?php

namespace App\Http\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowSocialsPage extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.settings.socials-page')->extends('layouts.app');
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }
}
