<?php

namespace App\Http\Livewire\Blocklist;

use Livewire\Component;

class ShowCreatePage extends Component
{
    public function render()
    {
        return view('livewire.blocklist.create-page')->extends('layouts.app');
    }
}
