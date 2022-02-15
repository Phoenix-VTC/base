<?php

use App\Http\Livewire\Jobs\ShowShowPage;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the job page', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $job = Job::factory()->create();

    $this->get(route('jobs.show', $job->id))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowShowPage::class)
        ->assertSeeText("Viewing Job #$job->id")
        ->assertSeeText($job->pickupCity->real_name)
        ->assertSeeText($job->destinationCity->real_name);
});

it('is redirected if not logged in', function () {
    $this->get(route('jobs.show', 1))
        ->assertRedirect(route('login'));
});

it('doesn\'t show staff actions if the user isn\'t staff', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $job = Job::factory()->create();

    $this->get(route('jobs.show', $job->id))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowShowPage::class)
        ->assertDontSeeText('Staff Actions');
});
