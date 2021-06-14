<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowIndexPage extends Component
{
    public Collection $screenshots;

    public function mount(): void
    {
        $this->screenshots = Screenshot::with(['user', 'votes'])->get(); // PAGINATE THIS BOIIII
    }

    public function render()
    {
        return view('livewire.screenshot-hub.index-page')->extends('layouts.app');
    }
}
