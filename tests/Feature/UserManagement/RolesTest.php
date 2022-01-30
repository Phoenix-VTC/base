<?php

use App\Http\Livewire\UserManagement\IndexDatatable;
use App\Http\Livewire\UserManagement\Roles\ShowIndexPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the roles page', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $this->get(route('user-management.roles.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndexPage::class)
        ->assertSeeText('Role Management');
});

it('is redirected if not logged in', function () {
    $this->get(route('user-management.roles.index'))
        ->assertRedirect();
});

it('returns 403 if not authorized', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('user-management.roles.index'))
        ->assertForbidden();
});
