<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ShowLeaderboard extends Component
{
    public Collection $event_wallets_all_time;
    public array $statistics;

    public function mount(): void
    {
        // Caches for 15 minutes
        $this->event_wallets_all_time = Cache::remember("event_wallets_top_10_all_time", 900, function () {
            return Wallet::with('holder')
                ->where('slug', 'event-xp')
                ->has('holder')
                ->orderByDesc('balance')
                ->limit(10)
                ->get();
        });

        $this->statistics = [
            'events_attended' => Event::getTotalEventsAttended(),
            'events_hosted' => Event::getTotalEventsHosted(),
            'total_distance' => Event::getTotalEventsDistance(),
        ];
    }

    public function render()
    {
        return view('livewire.events.leaderboard')->extends('layouts.events');
    }
}
