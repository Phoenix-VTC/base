<?php

use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the password confirm page', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->get(route('password.confirm'))
        ->assertSuccessful()
        ->assertSeeLivewire(Confirm::class)
        ->assertSeeText('Confirm your password');
});

it('it prompts a user for their password before visiting a protected page', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->get(route('settings.security'))
        ->assertRedirect(route('password.confirm'));

    $this->followingRedirects()
        ->get(route('settings.security'))
        ->assertSeeLivewire(Confirm::class);
});

test('a user must enter a password to confirm it', function () {
    Livewire::test(Confirm::class)
        ->call('confirm')
        ->assertHasErrors(['password' => 'required']);
});

test('a user must enter their own password to confirm it', function () {
    User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    Livewire::test('auth.passwords.confirm')
        ->set('password', 'not-password')
        ->call('confirm')
        ->assertHasErrors(['password' => 'password']);
});

test('a user who confirms their password gets redirected', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->be($user);

    $this->withSession(['url.intended' => route('settings.security')]);

    Livewire::test(Confirm::class)
        ->set('password', 'password')
        ->call('confirm')
        ->assertRedirect(route('settings.security'))
        ->assertSessionHasNoErrors();
});
