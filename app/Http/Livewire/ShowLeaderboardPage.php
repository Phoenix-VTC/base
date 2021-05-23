<?php

namespace App\Http\Livewire;

use Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ShowLeaderboardPage extends Component
{
    public LaravelSubQueryCollection $users;

    public function mount(): void
    {
        $this->users = User::whereHas('jobs', function ($q) {
            $q->whereMonth('finished_at', date('m'));
        })->orderByRelation(['jobs:distance' => function (Builder $q) {
            $q->whereMonth('finished_at', date('m'));
        }, 'desc', 'sum'])->remember(now()->addMinute())->get();
    }

    public function render()
    {
        return view('livewire.leaderboard-page')->extends('layouts.app');
    }
}
