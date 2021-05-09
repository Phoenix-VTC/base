<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class ShowJobOverviewPage extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.users.job-overview-page', [
            'jobs' => $this->user
                ->jobs()
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
