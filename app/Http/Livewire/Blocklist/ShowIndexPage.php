<?php

namespace App\Http\Livewire\Blocklist;

use App\Models\Blocklist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowIndexPage extends Component
{
    use AuthorizesRequests;

    public function mount(): void
    {
        $this->authorize('viewAny', Blocklist::class);
    }

    public function render()
    {
        return view('livewire.blocklist.index-page')->extends('layouts.app');
    }
}
