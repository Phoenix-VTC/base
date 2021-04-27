<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowPersonalOverviewPage extends Component
{
    public function render(): View
    {
        return view('livewire.jobs.personal-overview-page', [
            'jobs' => Job::where('user_id', Auth::id())
                ->with([
                    'pickupCity',
                    'destinationCity',
                    'pickupCompany',
                    'destinationCompany',
                    'cargo',
                ])
                ->orderByDesc('created_at')
                ->paginate(15)
        ])->extends('layouts.app');
    }
}
