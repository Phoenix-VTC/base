<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowAchievementsPage extends Component
{
    public User $user;
    public Collection $achievements;

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->achievements = $this->user
            ->achievements
            ->sortBy('details.name', SORT_NATURAL, false)
            ->sortByDesc('unlocked_at');
    }

    public function render()
    {
        return view('livewire.users.show-achievements-page')->extends('layouts.app');
    }
}
