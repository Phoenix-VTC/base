<?php

namespace App\Http\Livewire\Blocklist;

use Livewire\Component;

class ShowIndexPage extends Component
{
    public function render()
    {
        return view('livewire.blocklist.index-page')->extends('layouts.app');
    }
}
