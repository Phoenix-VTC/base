<?php

use App\Events\NewBlocklistEntry;
use App\Http\Livewire\Recruitment\ShowAcceptModal;
use App\Http\Livewire\Recruitment\ShowApplication;
use App\Http\Livewire\Recruitment\ShowBlocklistModal;
use App\Jobs\Recruitment\ProcessAcceptation;
use App\Mail\DriverApplication\ApplicationDenied;
use App\Models\Application;
use App\Models\Blocklist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use function PHPUnit\Framework\assertEquals;

uses(RefreshDatabase::class);

it('shows the show page', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    $this->get(route('recruitment.show', $application->uuid))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowApplication::class);
});

it('is redirected if not logged in', function () {
    $application = Application::factory()->create();
    $this->get(route('recruitment.show', $application->uuid))
        ->assertRedirect();
});

it('returns 403 if not authorized', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $application = Application::factory()->create();
    $this->get(route('recruitment.show', $application->uuid))
        ->assertForbidden();
});

it('displays the applicant information', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    $this->get(route('recruitment.show', $application->uuid))
        ->assertSeeText('Applicant Information')
        ->assertSeeText($application->steam_data['personaname'])
        ->assertSeeText($application->truckersmp_data['name'])
        ->assertSeeText($application->username)
        ->assertSeeText($application->email)
        ->assertSeeText($application->discord_username)
        ->assertSeeText($application->date_of_birth)
        ->assertSeeText($application->country);
});

it('displays the interview questions', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    $response = $this->get(route('recruitment.show', $application->uuid));

    $response->assertSeeText('Digital Interview');

    foreach (array_keys($application->application_answers->toArray()) as $question) {
        $response->assertSeeText($question);
    }
});

it('displays the interview answers', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    $response = $this->get(route('recruitment.show', $application->uuid));

    $response->assertSeeText('Digital Interview');

    foreach (array_values($application->application_answers->toArray()) as $answers) {
        $response->assertSeeText($answers);
    }
});

it('displays the application information', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    $this->get(route('recruitment.show', $application->uuid))
        ->assertSeeText('Application Information')
        ->assertSeeText('Unclaimed');
});

it('displays the truckersmp information', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->assertSeeText('TruckersMP Information')
        ->assertSeeText('Account created')
        ->assertSeeText(Carbon::parse($application->truckersmp_data['joinDate'])->toFormattedDateString());
});

it('can refresh the truckersmp information', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('clearTMPData')
        ->assertSuccessful()
        ->assertSeeText('TruckersMP data successfully refreshed!');
});

it('can claim applications', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Http::fake();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('claim')
        ->assertSuccessful()
        ->assertSeeText('Application claimed');

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return $request->url() === config('services.discord.webhooks.human-resources');
    });
});

it('can unclaim applications', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();
    $application->update(['claimed_by' => $user->id]);

    Http::fake();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('unclaim')
        ->assertSuccessful()
        ->assertSeeText('Application unclaimed');

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return $request->url() === config('services.discord.webhooks.human-resources');
    });
});

it('can change the application status', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();
    $application->update(['claimed_by' => $user->id]);

    $response = Livewire::test(ShowApplication::class, ['uuid' => $application->uuid]);

    $statuses = [
        'investigation',
        'awaiting_response',
        'incomplete',
        'pending',
    ];

    foreach ($statuses as $status) {
        Http::fake();

        $response->call('setStatus', $status)
            ->assertSuccessful()
            ->assertSeeText('Application status changed');

        Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
            return $request->url() === config('services.discord.webhooks.human-resources');
        });

        $application = $application->refresh();

        assertEquals($status, $application->status);
    }
});

it('cannot change the application status to an invalid status', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();
    $application->update(['claimed_by' => $user->id]);

    $response = Livewire::test(ShowApplication::class, ['uuid' => $application->uuid]);

    $response->call('setStatus', 'InvalidStatus')
        ->assertSeeText('Chosen status is invalid.');
});

it('cannot change the application status if it doesn\'t belong to the user', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('setStatus', 'investigation')
        ->assertForbidden();
});

it('cannot unclaim the application if it doesn\'t belong to the user', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('unclaim')
        ->assertForbidden();
});

it('can post a comment', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Http::fake();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->set('comment', 'A random comment')
        ->call('submitComment')
        ->assertSuccessful()
        ->assertSeeText('Comment submitted!')
        ->assertSeeText('A random comment');

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return $request->url() === config('services.discord.webhooks.human-resources');
    });
});

test('comment field is required', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('submitComment')
        ->assertHasErrors([
            'comment' => 'required'
        ]);
});

it('can delete a comment', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Http::fake();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->set('comment', 'A random comment')
        ->call('submitComment')
        ->call('deleteComment', $application->comments->first()->uuid)
        ->assertSeeText('Comment deleted!');

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return $request->url() === config('services.discord.webhooks.human-resources');
    });
});

it('can accept an application', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();
    $application->update(['claimed_by' => $user->id]);

    Queue::fake();
    Http::fake();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('accept')
        ->assertHasNoErrors()
        ->assertEmitted('openModal');

    $testingAccountDiscordId = '938403769916485683';

    Livewire::test(ShowAcceptModal::class, ['uuid' => $application->uuid])
        ->set('discord_id', $testingAccountDiscordId)
        ->call('submit')
        ->assertHasNoErrors();

    Queue::assertPushed(ProcessAcceptation::class);

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return $request->url() === config('services.discord.webhooks.human-resources');
    });
});

it('cannot accept the application if it doesn\'t belong to the user', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('accept')
        ->assertForbidden();
});

it('can deny an application', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();
    $application->update(['claimed_by' => $user->id]);

    Mail::fake();
    Http::fake();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('deny')
        ->assertSeeText('Application successfully');

    $application = $application->refresh();

    $this->assertEquals($application->status, 'denied');

    Mail::assertQueued(ApplicationDenied::class);
    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return $request->url() === config('services.discord.webhooks.human-resources');
    });
});

it('cannot deny the application if it doesn\'t belong to the user', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowApplication::class, ['uuid' => $application->uuid])
        ->call('deny')
        ->assertForbidden();
});

it('can blocklist an application', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();
    $application->update(['claimed_by' => $user->id]);

    Mail::fake();
    Event::fake();

    $livewire = Livewire::test(ShowBlocklistModal::class, ['uuid' => $application->uuid])
        ->set('reason', 'Some reason')
        ->call('submit')
        ->assertHasNoErrors();

    Mail::assertQueued(ApplicationDenied::class);

    $application = $application->refresh();
    $this->assertEquals($application->status, 'denied');

    $blocklist = Blocklist::query()
        ->exactSearch($application->truckersmp_id)
        ->first();

    $this->assertTrue($blocklist::exists());

    $livewire->assertredirect(route('user-management.blocklist.show', $blocklist?->id));

    Event::assertDispatched(NewBlocklistEntry::class);
});

it('cannot blocklist the application if it doesn\'t belong to the user', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $application = Application::factory()->create();

    Livewire::test(ShowBlocklistModal::class, ['uuid' => $application->uuid])
        ->assertForbidden();
});
