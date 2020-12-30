<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowDashboard extends Component
{
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.dashboard');
    }
}
