<?php

namespace App\Http\Livewire\Blocklist;

use Livewire\Component;

class ShowShowPage extends Component
{
    public function render()
    {
        return view('livewire.blocklist.show-page')->extends('layouts.app');
    }
}
