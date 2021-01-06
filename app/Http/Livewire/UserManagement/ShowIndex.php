<?php

namespace App\Http\Livewire\UserManagement;

use Illuminate\View\View;
use Livewire\Component;

class ShowIndex extends Component
{
    public function render(): View
    {
        return view('livewire.user-management.index')->extends('layouts.app');
    }
}
