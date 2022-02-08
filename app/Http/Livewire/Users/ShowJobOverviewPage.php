<?php

namespace App\Http\Livewire\Users;

use App\Enums\JobStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowJobOverviewPage extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.users.job-overview-page', [
            'jobs' => $this->user
                ->jobs()
                ->when(Auth::id() != $this->user->id, function ($query) {
                    return $query->where('status', JobStatus::Complete);
                })
                ->with([
                    'pickupCity',
                    'destinationCity',
                    'pickupCompany',
                    'destinationCompany',
                    'cargo',
                ])
                ->orderByDesc('created_at')
                ->paginate(15),
        ])->extends('layouts.app');
    }
}
