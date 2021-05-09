<?php

namespace App\Http\Livewire\Jobs\Submit;

use Livewire\Component;

class ShowSelectGamePage extends Component
{
    public function render()
    {
        return view('livewire.jobs.submit.show-select-game-page')->extends('layouts.app');
    }
}
