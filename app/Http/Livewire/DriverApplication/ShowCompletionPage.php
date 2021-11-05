<?php

namespace App\Http\Livewire\DriverApplication;

use App\Models\Application;
use Illuminate\View\View;
use Livewire\Component;

class ShowCompletionPage extends Component
{
    public object $application;

    public function mount($uuid): void
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.driver-application.show')->extends('layouts.driver-application');
    }
}
