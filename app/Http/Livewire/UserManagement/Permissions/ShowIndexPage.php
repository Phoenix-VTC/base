<?php

namespace App\Http\Livewire\UserManagement\Permissions;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class ShowIndexPage extends Component
{
    public Collection $permissions;

    public function mount(): void
    {
        session()->now('alert', ['type' => 'info', 'title' => 'Heads-up!', 'message' => 'Permissions cannot be modified via the PhoenixBase.<br>Contact a Developer in order to do this.']);

        $this->permissions = Permission::with('roles', 'users')->get();
    }

    public function render()
    {
        return view('livewire.user-management.permissions.index-page')->extends('layouts.app');
    }
}
