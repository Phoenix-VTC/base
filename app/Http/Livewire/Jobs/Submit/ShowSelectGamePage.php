<?php

namespace App\Http\Livewire\Jobs\Submit;

use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowSelectGamePage extends Component
{
    use AuthorizesRequests;

    public function mount(): void
    {
        $this->authorize('create', Job::class);
    }

    public function render()
    {
        return view('livewire.jobs.submit.show-select-game-page')->extends('layouts.app');
    }
}
