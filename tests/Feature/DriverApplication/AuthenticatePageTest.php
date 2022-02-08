<?php

use App\Http\Livewire\DriverApplication\ShowAuthPage;
use function Pest\Livewire\livewire;

it('has authenticate page', function () {
    $this->get(route('driver-application.authenticate'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowAuthPage::class)
        ->assertSeeText('Sign in with Steam');
});

it('is redirected if already logged in', function () {
    $this->withSession(['steam_user' => ['something']])
        ->get(route('driver-application.authenticate'))
        ->assertRedirect(route('driver-application.apply'));
});
