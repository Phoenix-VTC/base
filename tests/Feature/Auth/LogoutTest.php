<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

it('can log out an authenticated user', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->post(route('logout'))
        ->assertRedirect(route('dashboard'));

    $this->assertFalse(Auth::check());
});

it('cannot log out an unauthenticated user', function () {
    $this->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertFalse(Auth::check());
});
