<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowIndex extends Component
{
    use WithPagination;

    public function paginationView(): string
    {
        return 'vendor.livewire.pagination-links';
    }

    public function render(): View
    {
        return view('livewire.events.management.index', [
            'upcoming_events' => Event::with('host')
                ->where('start_date', '>=', Carbon::now()->toDateTimeString())
                ->orderBy('start_date')
                ->paginate(10)
        ])->extends('layouts.app');
    }
}
