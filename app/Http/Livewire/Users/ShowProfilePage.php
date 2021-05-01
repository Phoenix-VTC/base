<?php

namespace App\Http\Livewire\Users;

use App\Enums\JobStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowProfilePage extends Component
{
    public User $user;
    public $recent_jobs;

    public function mount(int $id): void
    {
        if (Auth::user()->can('manage users')) {
            $this->user = User::withTrashed()
                ->with([
                    'jobs',
                    'roles',
                    'permissions',
                    'application',
                    'vacation_requests',
                    'wallets',
                    'modelSettings'
                ])->findOrFail($id);
        } else {
            $this->user = User::with([
                'jobs',
                'roles',
            ])->findOrFail($id);
        }

        $this->recent_jobs = $this->user->jobs()
            ->orderBy('created_at', 'desc')
            ->where('status', JobStatus::Complete)
            ->with('pickupCity', 'destinationCity')
            ->take(10)
            ->get();
    }

    public function render()
    {
        if ($this->user->trashed()) {
            session()->now('alert', [
                'type' => 'warning',
                'title' => 'Heads-up!',
                'message' => 'You\'re currently viewing the profile of a deleted user. This is a staff-only action.<br><br>Do <b>not</b> restore users unless given permission from Management.'
            ]);
        }

        return view('livewire.users.profile-page')->extends('layouts.app');
    }

    public function deleteUser(): void
    {
        if (Auth::user()->cannot('manage users')) {
            abort(403, 'You don\'t have permission to delete users.');
        }

        if ($this->user->id === Auth::id()) {
            abort(403, 'You can\'t delete your own account. Contact Management in order to do this.');
        }

        $this->user->delete();

        $this->user->refresh();
    }

    public function restoreUser(): void
    {
        if (Auth::user()->cannot('manage users')) {
            abort(403, 'You don\'t have permission to restore users.');
        }

        $this->user->restore();

        $this->user->refresh();
    }
}
