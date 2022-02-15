<?php

use App\Http\Livewire\Auth\Passwords\Reset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

it('shows the password reset page', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => Carbon::now(),
    ]);

    $this->get(route('password.reset', [
        'email' => $user->email,
        'token' => $token,
    ]))
        ->assertSuccessful()
        ->assertSee($user->email)
        ->assertSeeLivewire(Reset::class);
});

it('can reset the password', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => Carbon::now(),
    ]);

    Livewire::test(Reset::class, [
        'token' => $token,
    ])
        ->set('email', $user->email)
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('resetPassword');

    $this->assertTrue(Auth::attempt([
        'email' => $user->email,
        'password' => 'new-password',
    ]));
});

it('tests the validation rules', function ($field, $value, $rule) {
    Livewire::test(Reset::class, [
        'token' => Str::random(),
    ])
        ->set($field, $value)
        ->call('resetPassword')
        ->assertHasErrors([$field => $rule]);
})->with([
    'token is null' => ['token', null, 'required'],

    'email is not a string' => ['email', ['something'], 'string'],
    'email is null' => ['email', null, 'required'],
    'email is invalid' => ['email', 'invalid', 'email'],

    'password is not a string' => ['password', ['something'], 'string'],
    'password is null' => ['password', null, 'required'],
    'password is too short' => ['password', 'short', 'min'],
]);
