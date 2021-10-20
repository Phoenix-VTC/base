<?php

use App\Http\Livewire\Jobs\Submit\ShowSelectGamePage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the choose game page', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('jobs.choose-game'))
        ->assertSuccessful()
        ->assertSeeText('Choose a game')
        ->assertSeeText('Euro Truck Simulator 2')
        ->assertSeeText('American Truck Simulator')
        ->assertSeeLivewire(ShowSelectGamePage::class);
});
