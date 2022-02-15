<?php

use App\Http\Livewire\DriverApplication\ShowCompletionPage;
use App\Models\Application;

it('shows the completion page', function () {
    $application = Application::factory()->create();

    $this->get(route('driver-application.status', $application->uuid))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowCompletionPage::class)
        ->assertSeeText('Thank you for applying!');
});
