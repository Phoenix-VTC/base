<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ShowDashboard extends Component
{
    public array $stats;

    public function mount(): void
    {
        $this->stats = $this->calculateUserStats();
    }

    public function render(): View
    {
        return view('livewire.dashboard')->extends('layouts.app');
    }

    public function calculateUserStats(): array
    {
        return Cache::remember('user_stats_'. Auth::id(), 900, function () {
            // Convert income to the user's preferred income
            if (Auth::user()->settings()->get('preferences.currency') === 'dollar') {
                $income_current_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->month)->sum('total_income') * 1.21;
                $income_previous_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->subMonth())->sum('total_income') * 1.21;
            } else {
                $income_current_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->month)->sum('total_income');
                $income_previous_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->subMonth())->sum('total_income');
            }

            // Convert distance to the user's preferred distance
            if (Auth::user()->settings()->get('preferences.distance') === 'miles') {
                $distance_current_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->month)->sum('distance') / 1.609;
                $distance_previous_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->subMonth())->sum('distance') / 1.609;
            } else {
                $distance_current_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->month)->sum('distance');
                $distance_previous_month = Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->subMonth())->sum('distance');
            }

            return [
                'delivery_count' => [
                    'current_month' => Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->month)->count(),
                    'previous_month' => Auth::user()->jobs()->whereMonth('finished_at', Carbon::now()->subMonth()->month)->count(),
                ],
                'income' => [
                    'current_month' => $income_current_month,
                    'previous_month' => $income_previous_month,
                ],
                'distance' => [
                    'current_month' => $distance_current_month,
                    'previous_month' => $distance_previous_month,
                ],
            ];
        });
    }
}
