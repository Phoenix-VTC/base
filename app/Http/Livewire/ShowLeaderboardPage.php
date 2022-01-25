<?php

namespace App\Http\Livewire;

use Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Http\Request;

class ShowLeaderboardPage extends Component
{
    // Request data
    public string $month;
    public string $orderBy;

    public LaravelSubQueryCollection|Collection $users;

    public function mount(Request $request): void
    {
        $month = $request->get('month');
        $orderBy = $request->get('orderBy');

        // Set month value to current month if request isn't a month number
        if ($month >= 1 && $month <= 12) {
            $this->month = $month;
        } else {
            $this->month = date('m');
        }

        // Set leaderboardMeasurement value to distance if request isn't 'income', 'deliveries' or 'distance'
        if (in_array($orderBy, ['income', 'deliveries', 'distance'])) {
            $this->orderBy = $orderBy;
        } else {
            $this->orderBy = 'distance';
        }

        switch ($this->orderBy) {
            case 'income':
                $this->users = User::whereHas('jobs', function ($q) {
                    $q->whereMonth('finished_at', $this->month);
                })->orderByRelation(['jobs:total_income' => function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                }, 'desc', 'sum'])->get();
                break;
            case 'deliveries':
                $this->users = User::whereHas('jobs', function ($q) {
                    $q->whereMonth('finished_at', $this->month);
                })->withCount(['jobs' => function ($query) {
                    $query->whereMonth('finished_at', $this->month);
                }])->orderBy('jobs_count', 'desc')
                    ->get();
                break;
            case 'distance':
                $this->users = User::whereHas('jobs', function ($q) {
                    $q->whereMonth('finished_at', $this->month);
                })->orderByRelation(['jobs:distance' => function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                }, 'desc', 'sum'])->get();
                break;
        }
    }

    public function render()
    {
        return view('livewire.leaderboard-page')->extends('layouts.app');
    }
}
