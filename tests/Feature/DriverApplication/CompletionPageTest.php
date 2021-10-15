<?php

use App\Http\Livewire\DriverApplication\ShowCompletion;
use App\Models\Application;

it('shows the completion page', function () {
    $application = Application::factory()->create();

    $this->get(route('driver-application.status', $application->uuid))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowCompletion::class)
        ->assertSeeText('Thank you for applying!');
});
