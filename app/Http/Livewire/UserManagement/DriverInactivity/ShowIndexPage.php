<?php

namespace App\Http\Livewire\UserManagement\DriverInactivity;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Livewire\Component;

class ShowIndexPage extends Component
{
    // Request data
    public string $month;

    public function mount(Request $request): void
    {
        $month = $request->get('month');

        // Set month value to current month if request isn't a month number
        if ($month >= 1 && $month <= 12) {
            $this->month = $month;
        } else {
            $this->month = date('m');
        }
    }

    public function render(): View
    {
        $inactive_drivers = User::withCount(['jobs' => function (Builder $q) {
            $q->whereMonth('finished_at', $this->month);
        }])->withSum(['jobs:distance' => function (Builder $q) {
            $q->whereMonth('finished_at', $this->month);
        }], 'distance')->with(['roles'])
            ->with([
                "vacation_requests" => function ($q) {
                    $q->whereMonth('start_date', '<=', $this->month)
                        ->whereMonth('end_date', '>=', $this->month);
                },
            ])
            ->orderBy('jobs_distance_sum')
            ->paginate(30);

        return view('livewire.user-management.driver-inactivity.index-page', [
            'inactive_drivers' => $inactive_drivers
        ])->extends('layouts.app');
    }
}
