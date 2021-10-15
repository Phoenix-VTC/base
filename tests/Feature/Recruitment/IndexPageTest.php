<?php

use App\Http\Livewire\Recruitment\ShowIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the index page', function () {
    $user = User::factory()->create()->assignRole('human resources');
    $this->be($user);

    $this->get(route('recruitment.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndex::class)
        ->assertSeeText('Driver Applications');
});

it('is redirected if not logged in', function () {
    $this->get(route('recruitment.index'))
        ->assertRedirect();
});

it('returns 403 if not authorized', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('recruitment.index'))
        ->assertForbidden();
});
