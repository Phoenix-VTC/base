<?php

use App\Http\Livewire\Auth\Passwords\Email;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the password request page', function () {
    $this->get(route('password.request'))
        ->assertSuccessful()
        ->assertSeeLivewire(Email::class)
        ->assertSeeText('Reset password');
});

it('tests the validation rules', function ($field, $value, $rule) {
    Livewire::test(Email::class)
        ->set($field, $value)
        ->call('sendResetPasswordLink')
        ->assertHasErrors([$field => $rule]);
})->with([
    'email is not a string' => ['email', ['something'], 'string'],
    'email is null' => ['email', null, 'required'],
    'email is not a valid email' => ['email', 'not-an-email', 'email'],
]);

it('sends an email if the user enters a valid email address', function () {
    $user = User::factory()->create();

    Livewire::test(Email::class)
        ->set('email', $user->email)
        ->call('sendResetPasswordLink')
        ->assertNotSet('emailSentMessage', false);

    $this->assertDatabaseHas('password_resets', [
        'email' => $user->email,
    ]);
});
