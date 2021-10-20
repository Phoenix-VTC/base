<?php

use App\Enums\JobStatus;
use App\Http\Livewire\Jobs\ShowPersonalOverviewPage;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the personal job overview page', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('jobs.personal-overview'))
        ->assertSuccessful()
        ->assertSeeText('Personal Job Overview')
        ->assertSeeText('Submit New Job')
        ->assertSeeLivewire(ShowPersonalOverviewPage::class);
});

it('shows the user\'s jobs', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $job = $user->jobs()->create([
        'game_id' => 1,
        'pickup_city_id' => City::factory()->create()->id,
        'destination_city_id' => City::factory()->create()->id,
        'pickup_company_id' => Company::factory()->create()->id,
        'destination_company_id' => Company::factory()->create()->id,
        'cargo_id' => Cargo::factory()->create()->id,
        'finished_at' => Carbon::now(),
        'distance' => 1200,
        'load_damage' => 0,
        'estimated_income' => 5000,
        'total_income' => 5000,
        'status' => JobStatus::Complete,
    ]);

    $this->get(route('jobs.personal-overview'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowPersonalOverviewPage::class)
        ->assertSeeText('Personal Job Overview')
        ->assertSeeText(App\Models\Game::getAbbreviationById($job->game_id))
        ->assertSeeText(ucwords($job->pickupCity->real_name))
        ->assertSeeText(ucwords($job->pickupCompany->name))
        ->assertSeeText(ucwords($job->destinationCity->real_name))
        ->assertSeeText(ucwords($job->destinationCompany->name))
    ;
});

it('doesn\'t show another user\'s jobs', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $anotherUser = User::factory()->create()->assignRole('driver');

    $job = $anotherUser->jobs()->create([
        'game_id' => 1,
        'pickup_city_id' => City::factory()->create()->id,
        'destination_city_id' => City::factory()->create()->id,
        'pickup_company_id' => Company::factory()->create()->id,
        'destination_company_id' => Company::factory()->create()->id,
        'cargo_id' => Cargo::factory()->create()->id,
        'finished_at' => Carbon::now(),
        'distance' => 1200,
        'load_damage' => 0,
        'estimated_income' => 5000,
        'total_income' => 5000,
        'status' => JobStatus::Complete,
    ]);

    $this->get(route('jobs.personal-overview'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowPersonalOverviewPage::class)
        ->assertSeeText('Personal Job Overview')
        ->assertDontSeeText(App\Models\Game::getAbbreviationById($job->game_id))
        ->assertDontSeeText(ucwords($job->pickupCity->real_name))
        ->assertDontSeeText(ucwords($job->pickupCompany->name))
        ->assertDontSeeText(ucwords($job->destinationCity->real_name))
        ->assertDontSeeText(ucwords($job->destinationCompany->name))
    ;
});

it('shows the user\'s wallet balance', function() {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('jobs.personal-overview'))
        ->assertSuccessful()
        ->assertSeeText(number_format($user->default_wallet_balance));
});
