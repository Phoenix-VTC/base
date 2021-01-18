<?php

namespace App\Http\Livewire\VacationRequests;

use App\Models\VacationRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndex extends Component
{
    public Collection $vacation_requests;

    public function mount(): void
    {
        $this->vacation_requests = VacationRequest::where('user_id', Auth::id())->with('staff')->get();
    }

    public function render(): View
    {
        return view('livewire.vacation-requests.index')->extends('layouts.app');
    }
}
