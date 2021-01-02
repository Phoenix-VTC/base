<?php

namespace App\Http\Livewire\Recruitment;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowApplication extends Component
{
    public \App\Models\Application $application;

    public function mount($uuid)
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.recruitment.show')->extends('layouts.app');
    }

    public function claim()
    {
        $this->application->claimed_by = Auth::id();
        $this->application->save();
    }

    public function unclaim()
    {
        $this->application->claimed_by = null;
        $this->application->save();
    }
}
