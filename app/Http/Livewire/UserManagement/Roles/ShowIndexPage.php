<?php

namespace App\Http\Livewire\UserManagement\Roles;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ShowIndexPage extends Component
{
    public Collection $roles;

    public function mount(): void
    {
        session()->now('alert', ['type' => 'info', 'title' => 'Heads-up!', 'message' => 'Roles cannot be modified via the PhoenixBase.<br>Contact a Developer in order to do this.']);

        $this->roles = Role::with('permissions', 'users')->get();
    }

    public function render()
    {
        return view('livewire.user-management.roles.index-page')->extends('layouts.app');
    }
}
