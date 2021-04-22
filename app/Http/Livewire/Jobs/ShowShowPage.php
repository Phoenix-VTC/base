<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class ShowShowPage extends Component
{
    public Job $job;

    public function mount(Job $job): void
    {
        $this->job = $job->load('user', 'pickupCity', 'destinationCity');
    }

    public function render(): View
    {
        return view('livewire.jobs.show-page')->extends('layouts.app');
    }

    public function delete(): Redirector
    {
        if (!Auth::user()->can('manage users')) {
            abort(403, 'You don\'t have permission to delete jobs.');
        }

        $this->job->delete();

        return redirect()->route('jobs.overview');
    }
}
