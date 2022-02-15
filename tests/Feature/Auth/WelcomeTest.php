<?php

use App\Http\Livewire\Auth\ShowWelcomeForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

it('shows the welcome page if a valid token is provided', function () {
    $welcomeToken = Str::random(64);

    User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->addDay(),
    ]);

    $this->get(route('welcome', ['token' => $welcomeToken]))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowWelcomeForm::class)
        ->assertSeeText('Choose your password');
});

it('returns a 404 if an invalid is provided', function () {
    // Test it with a "random" value
    $welcomeToken = 'invalid-token';

    $this->get(route('welcome', ['token' => $welcomeToken]))
        ->assertNotFound();

    // Test it with an incorrect but correct length value
    $welcomeToken = Str::random(64);

    $this->get(route('welcome', ['token' => $welcomeToken]))
        ->assertNotFound();
});

it('returns a 404 if the provided token exists in the database, but valid_until is null', function () {
    $welcomeToken = Str::random(64);

    User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => null,
    ]);

    $this->get(route('welcome', ['token' => $welcomeToken]))
        ->assertNotFound();
});

it('returns a 403 if the provided token exists in the database, but it is not 64 characters', function () {
    $welcomeToken = Str::random(60);

    User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->addDay(),
    ]);

    $this->get(route('welcome', ['token' => $welcomeToken]))
        ->assertForbidden();
});

it('returns a 403 if the provided token exists in the database, but the valid_until date has passed', function () {
    $welcomeToken = Str::random(64);

    User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->subDay(),
    ]);

    $this->get(route('welcome', ['token' => $welcomeToken]))
        ->assertForbidden();
});

it('tests the validation rules', function ($field, $value, $rule) {
    $welcomeToken = Str::random(64);

    User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->addDay(),
    ]);

    Livewire::test(ShowWelcomeForm::class, ['token' => $welcomeToken])
        ->set($field, $value)
        ->call('submit')
        ->assertHasErrors([$field => $rule]);
})->with([
    'password is null' => ['password', null, 'required'],
    'password is not a string' => ['password', ['something'], 'string'],
    'password is too short' => ['password', 'short', 'min'],
]);

it('can set a password', function () {
    $welcomeToken = Str::random(64);

    User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->addDay(),
    ]);

    Livewire::test(ShowWelcomeForm::class, ['token' => $welcomeToken])
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('submit')
        ->assertSuccessful()
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticated();
});

it('saves the correct password hash', function () {
    $welcomeToken = Str::random(64);

    $user = User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->addDay(),
    ]);

    Livewire::test(ShowWelcomeForm::class, ['token' => $welcomeToken])
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('submit');

    $this->assertTrue(Hash::check('password', $user->fresh()->password));
});

it('invalidates the welcome_token and welcome_valid_until after choosing a password', function () {
    $welcomeToken = Str::random(64);

    $user = User::factory()->create([
        'welcome_token' => $welcomeToken,
        'welcome_valid_until' => now()->addDay(),
    ]);

    Livewire::test(ShowWelcomeForm::class, ['token' => $welcomeToken])
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('submit');

    $this->assertNull($user->fresh()->welcome_token);
    $this->assertNull($user->fresh()->welcome_valid_until);
});
