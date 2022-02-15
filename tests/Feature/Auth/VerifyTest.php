<?php

use App\Http\Livewire\Auth\Verify;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can view the verification page', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Auth::login($user);

    $this->get(route('verification.notice'))
        ->assertSuccessful()
        ->assertSeeLivewire('auth.verify');
});

it('can send a verification email', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user);

    Livewire::test(Verify::class)
        ->call('resend')
        ->assertEmitted('resent');
});

it('can verify', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Auth::login($user);

    $url = URL::temporarySignedRoute('verification.verify', Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
        'id' => $user->getKey(),
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    $this->get($url)
        ->assertRedirect(route('dashboard'));

    $this->assertTrue($user->hasVerifiedEmail());
});
