<?php

namespace App\Http\Livewire\Recruitment;

use App\Models\Application;
use Livewire\Component;

class ShowIndex extends Component
{
    public object $applications;

    public function mount()
    {
        $this->applications = Application::all();
    }

    public function render()
    {
        return view('livewire.recruitment.index');
    }
}
