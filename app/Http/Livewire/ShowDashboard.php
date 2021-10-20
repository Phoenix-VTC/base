<?php

namespace App\Http\Livewire;

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use willvincent\Feeds\Facades\FeedsFacade;

class ShowDashboard extends Component
{
    public array $personal_stats;
    public Collection $recent_jobs;
    public array $recent_news;
    public Collection $today_overview;

    public function mount(): void
    {
        $this->personal_stats = $this->calculatePersonalStats();

        $this->recent_jobs = Job::orderBy('created_at', 'desc')
            ->where('status', JobStatus::Complete)
            ->with('user', 'destinationCity')
            ->take(5)
            ->get();

        $this->today_overview = User::whereHas('jobs', function ($q) {
            // Get the users that have finished a job today
            $q->whereDate('finished_at', Carbon::today());
        })->with(['jobs' => function ($q) {
            // Then include today's jobs of those users
            $q->whereDate('finished_at', Carbon::today());
        }])->take(10)
            ->get();

        $this->recent_news = $this->getRecentNewsPosts();
    }

    public function render(): View
    {
        return view('livewire.dashboard')->extends('layouts.app');
    }

    public function calculatePersonalStats(): array
    {
        // Convert income to the user's preferred income
        if (Auth::user()->settings()->get('preferences.currency') === 'dollar') {
            $income_current_month = Auth::user()
                    ->jobs()
                    ->whereMonth('finished_at', Carbon::now()->month)
                    ->sum('total_income') * 1.21;
            $income_previous_month = Auth::user()
                    ->jobs()
                    ->whereMonth('finished_at', Carbon::now()->subMonth()->month)
                    ->sum('total_income') * 1.21;
        } else {
            $income_current_month = Auth::user()
                ->jobs()
                ->whereMonth('finished_at', Carbon::now()->month)
                ->sum('total_income');
            $income_previous_month = Auth::user()
                ->jobs()
                ->whereMonth('finished_at', Carbon::now()->subMonth()->month)
                ->sum('total_income');
        }

        // Convert distance to the user's preferred distance
        if (Auth::user()->settings()->get('preferences.distance') === 'miles') {
            $distance_current_month = Auth::user()
                    ->jobs()
                    ->whereMonth('finished_at', Carbon::now()->month)
                    ->sum('distance') / 1.609;
            $distance_previous_month = Auth::user()
                    ->jobs()
                    ->whereMonth('finished_at', Carbon::now()->subMonth()->month)
                    ->sum('distance') / 1.609;
        } else {
            $distance_current_month = Auth::user()
                ->jobs()
                ->whereMonth('finished_at', Carbon::now()->month)
                ->sum('distance');
            $distance_previous_month = Auth::user()
                ->jobs()
                ->whereMonth('finished_at', Carbon::now()->subMonth()->month)
                ->sum('distance');
        }

        return [
            'delivery_count' => [
                'current_month' => Auth::user()
                    ->jobs()
                    ->whereMonth('finished_at', Carbon::now()->month)
                    ->count(),
                'previous_month' => Auth::user()
                    ->jobs()
                    ->whereMonth('finished_at', Carbon::now()->subMonth()->month)
                    ->count(),
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
    }

    public function getRecentNewsPosts(): array
    {
        $feed = FeedsFacade::make('https://phoenixvtc.com/feed');

        // Manually convert this to an array, otherwise Alpine dies because of Livewire lol
        $items = [];
        foreach ($feed->get_items() as $item) {
            $items[] = [
                'title' => $item->get_title(),
                'description' => $item->get_description(),
                'link' => $item->get_link(),
            ];
        }

        return $items;
    }
}
