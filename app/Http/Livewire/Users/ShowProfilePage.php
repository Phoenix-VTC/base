<?php

namespace App\Http\Livewire\Users;

use App\Enums\JobStatus;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowProfilePage extends Component
{
    use AuthorizesRequests;

    public User $user;

    public $recent_jobs;

    public function mount(User $user): void
    {
        $this->user = $user;

        if ($this->user->deleted_at && ! Auth::user()->can('manage users')) {
            abort(404);
        }

        if (Auth::user()->can('manage users')) {
            $this->user::query()->with([
                'jobs',
                'roles',
                'permissions',
                'application',
                'vacation_requests',
                'wallets',
                'modelSettings',
            ])->get();
        } else {
            $this->user::query()->with([
                'jobs',
                'roles',
            ])->get();
        }

        $this->recent_jobs = $this->user->jobs()
            ->orderBy('created_at', 'desc')
            ->where('status', JobStatus::Complete)
            ->with([
                'pickupCity',
                'pickupCompany',
                'destinationCity',
                'destinationCompany',
            ])
            ->take(10)
            ->get();
    }

    public function render()
    {
        if ($this->user->trashed()) {
            session()->now('alert', [
                'type' => 'warning',
                'title' => 'Heads-up!',
                'message' => 'You\'re currently viewing the profile of a deleted user. This is a staff-only action.<br><br>Do <b>not</b> restore users unless given permission from Management.',
            ]);
        }

        return view('livewire.users.profile-page')->extends('layouts.app');
    }

    public function deleteUser(): void
    {
        $this->authorize('delete', $this->user);

        $this->user->delete();

        $this->user->refresh();
    }

    public function restoreUser(): void
    {
        $this->authorize('restore', $this->user);

        if (Auth::user()->cannot('manage users')) {
            abort(403, 'You don\'t have permission to restore users.');
        }

        $this->user->restore();

        $this->user->refresh();
    }
}
