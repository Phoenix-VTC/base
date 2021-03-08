<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class ShowOverview extends Component
{

    public function render(): View
    {
        return view('livewire.events.overview', [
            'events' => Event::with('host')
                ->where('start_date', '>=', Carbon::now()->toDateTimeString())
                ->where('published', true)
                ->orderBy('start_date')
                ->paginate(9),
        ])->extends('layouts.events');
    }
}
