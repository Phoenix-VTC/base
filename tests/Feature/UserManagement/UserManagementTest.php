<?php

use App\Http\Livewire\UserManagement\IndexDatatable;
use App\Http\Livewire\UserManagement\ShowIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the user management page', function () {
    $user = User::factory()->create()->assignRole('human resources');
    $this->be($user);

    $this->get(route('user-management.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndex::class)
        ->assertSeeLivewire(IndexDatatable::class)
        ->assertSeeText('User Management');
});

it('is redirected if not logged in', function () {
    $this->get(route('user-management.index'))
        ->assertRedirect();
});

it('returns 403 if not authorized', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('user-management.index'))
        ->assertForbidden();
});

// TODO: Test Http/Livewire/UserManagement/IndexDatatable 22..46 ............ 82.2 %
