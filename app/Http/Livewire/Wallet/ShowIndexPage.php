<?php

namespace App\Http\Livewire\Wallet;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndexPage extends Component
{
    public User $user;
    public Collection $wallets;

    public function mount(): void
    {
        $this->user = Auth::user()
            ->load('wallets', 'wallets.holder');
    }

    public function render(): View
    {
        return view('livewire.wallet.index-page')->extends('layouts.app');
    }
}
