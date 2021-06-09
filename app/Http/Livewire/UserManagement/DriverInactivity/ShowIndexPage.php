<?php

namespace App\Http\Livewire\UserManagement\DriverInactivity;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class ShowIndexPage extends Component
{
    private LengthAwarePaginator $inactive_drivers;

    public function mount(): void
    {
        $this->inactive_drivers = $this->getInactiveDrivers();
    }

    public function render()
    {
        return view('livewire.user-management.driver-inactivity.index-page', ['inactive_drivers' => $this->inactive_drivers])->extends('layouts.app');

//        return view('livewire.user-management.driver-inactivity.index-page', [
//            'inactive_drivers' => User::whereHas('jobs', function (Builder $query) {
//                $query->whereMonth('finished_at', date('m'))
//                    ->groupBy('id')
//                    ->havingRaw('SUM(distance) < ?', [1000]);
//            })
//                ->withCount(['jobs AS total_distance' => function (Builder $query) {
//                    $query->whereMonth('finished_at', date('m'));
//                }])
//                ->paginate(30)
//        ])->extends('layouts.app');
    }

    public function getInactiveDrivers(): LengthAwarePaginator
    {
        $no_jobs = User::whereDoesntHave('jobs', function (Builder $query) {
            $query->whereMonth('finished_at', date('m'));
        })->withCount(['jobs AS total_jobs', 'jobs AS total_distance' => function (Builder $query) {
            $query->whereMonth('finished_at', date('m'));
        }])->paginate(30);

        return $no_jobs;
    }
}
