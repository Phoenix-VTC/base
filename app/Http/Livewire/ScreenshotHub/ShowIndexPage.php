<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Component;

class ShowIndexPage extends Component
{
    // Request data
    public string $range;
    public string $orderBy;
    public bool $desc;

    public Collection $screenshots;

    public function mount(Request $request): void
    {
        $range = $request->get('range');
        $orderBy = $request->get('orderBy');

        if (in_array($range, ['week', 'month', 'year'])) {
            $this->range = $range;
        } else {
            $this->range = 'week';
        }

        if (in_array($orderBy, ['votes_count', 'created_at'])) {
            $this->orderBy = $orderBy;
        } else {
            $this->orderBy = 'created_at';
        }

        $this->desc = (bool)$request->get('desc', false);

        $this->screenshots = Screenshot::with(['user', 'votes'])
            ->has('user')
            ->withCount('votes')
            ->whereDate('created_at', '>', Carbon::parse("-1 $this->range"))
            ->orderByRaw("$this->orderBy " . ($this->desc ? 'DESC' : ''))
            ->get(); // PAGINATE THIS BOIIII

        ray($this->screenshots->toArray());
    }

    public function render()
    {
        return view('livewire.screenshot-hub.index-page')->extends('layouts.app');
    }
}
