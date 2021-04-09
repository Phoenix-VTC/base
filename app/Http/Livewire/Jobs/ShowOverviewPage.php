<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowOverviewPage extends Component
{
    public function render(): View
    {
        return view('livewire.jobs.overview-page', [
            'jobs' => Job::where('user_id', Auth::id())
                ->firstOrFail()
                ->with([
                    'pickupCity',
                    'destinationCity',
                    'pickupCompany',
                    'destinationCompany',
                    'cargo',
                ])
                ->paginate(15)
        ])->extends('layouts.app');
    }
}
