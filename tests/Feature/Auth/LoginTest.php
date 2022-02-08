<?php

use App\Http\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('shows the login page', function () {
    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSeeLivewire(Login::class)
        ->assertSeeText('Sign in to your account');
});

it('is redirected to the dashboard if already logged in', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->get(route('login'))
        ->assertRedirect(route('dashboard'));
});

it('can log in', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate');

    $this->assertAuthenticatedAs($user);
});

it('is redirected to the dashboard after logging in', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertRedirect(route('dashboard'));
});

it('tests the validation rules', function ($field, $value, $rule) {
    Livewire::test(Login::class)
        ->set($field, $value)
        ->call('authenticate')
        ->assertHasErrors([$field => $rule]);
})->with([
    'email is not a string' => ['email', ['something'], 'string'],
    'email is null' => ['email', null, 'required'],
    'email is not a valid email' => ['email', 'not an email', 'email'],

    'password is not a string' => ['password', ['something'], 'string'],
    'password is null' => ['password', null, 'required'],
]);

it('shows an error if the credentials are invalid', function () {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'bad-password')
        ->call('authenticate')
        ->assertHasErrors('email')
        ->assertSeeText('These credentials do not match our records.');

    $this->assertFalse(Auth::check());
});
