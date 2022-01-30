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

        // Set leaderboardMeasurement value to distance if it isn't in the list.
        if (in_array($orderBy, ['income', 'deliveries', 'distance', 'job_points', 'driver_level', 'driver_points'])) {
            $this->orderBy = $orderBy;
        } else {
            $this->orderBy = 'distance';
        }

        switch ($this->orderBy) {
            case 'income':
                $this->users = User::whereHas('jobs', function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                })->orderByRelation(['jobs:total_income' => function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                }, 'desc', 'sum'])->get();
                break;
            case 'deliveries':
                $this->users = User::whereHas('jobs', function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                })->withCount(['jobs' => function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                }])->orderBy('jobs_count', 'desc')
                    ->get();
                break;
            case 'distance':
                $this->users = User::whereHas('jobs', function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                })->orderByRelation(['jobs:distance' => function (Builder $q) {
                    $q->whereMonth('finished_at', $this->month);
                }, 'desc', 'sum'])->get();
                break;
            case 'job_points':
                $users = User::query()
                    // Check if the user has a 'job-xp' wallet
                    ->whereHas('wallets', function (Builder $q) {
                        $q->where('slug', 'job-xp');
                    })
                    // Order it by a sum of the 'job-xp' wallet transaction amounts for the specified month
                    ->orderByRelation([
                        'transactions:amount' => function (Builder $q) {
                            $q->whereRelation('wallet', 'slug', 'job-xp')
                                ->whereMonth('created_at', $this->month);
                        }, 'desc', 'sum',
                    ])->get();

                // Filter out the users where transactions_amount_sum is null
                $this->users = $users->filter(function ($user) {
                    return $user->transactions_amount_sum !== null;
                });
                break;
            case 'driver_level':
                $this->users = User::query()
                    ->where('driver_level', '>', 0)
                    ->orderBy('driver_level', 'desc')
                    ->get();
                break;
            case 'driver_points':
                $this->users = User::query()
                    // Check if the user has a 'job-xp' or 'event-xp' wallet
                    ->whereHas('wallets', function (Builder $q) {
                        $q->where('slug', 'job-xp')
                            ->orWhere('slug', 'event-xp');
                    })
                    // Order it by a sum of the two wallets transaction amounts for the specified month
                    ->orderByRelation([
                        'transactions:amount' => function (Builder $q) {
                            $q->whererelation('wallet', 'slug', 'job-xp')
                                ->orWhereRelation('wallet', 'slug', 'event-xp')
                                ->whereMonth('created_at', $this->month);
                        }, 'desc', 'sum',
                    ])->get();

                // Filter out the users where transactions_amount_sum is null
                $this->users = $this->users->filter(function ($user) {
                    return $user->transactions_amount_sum !== null;
                });
                break;
        }
    }

    public function render()
    {
        return view('livewire.leaderboard-page')->extends('layouts.app');
    }
}
