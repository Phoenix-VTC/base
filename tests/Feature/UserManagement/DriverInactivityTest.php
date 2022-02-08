<?php

use App\Http\Livewire\UserManagement\DriverInactivity\ShowIndexPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the driver inactivity page', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $this->get(route('user-management.driver-inactivity.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndexPage::class)
        ->assertSeeText('Driver Inactivity');
});

it('is redirected if not logged in', function () {
    $this->get(route('user-management.driver-inactivity.index'))
        ->assertRedirect();
});

it('returns 403 if not authorized', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('user-management.driver-inactivity.index'))
        ->assertForbidden();
});

it('can display the chosen month', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    for ($monthNumber = 1; $monthNumber < 12; $monthNumber++) {
        $this->get(route('user-management.driver-inactivity.index', ['month' => $monthNumber]))
            ->assertSeeText(Carbon\Carbon::create()->month($monthNumber)->startOfMonth()->isoFormat('MMMM'));
    }
});

test('month defaults to current month if invalid input', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $this->get(route('user-management.driver-inactivity.index', ['month' => 'InvalidMonth']))
        ->assertSeeText(date('F'));
});
