<?php

use App\Http\Livewire\VacationRequests\ShowCreate;
use App\Http\Livewire\VacationRequests\ShowIndex;
use App\Models\User;
use App\Models\VacationRequest;
use App\Notifications\VacationRequest\NewVacationRequest;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the vacation request index page', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->get(route('vacation-requests.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndex::class)
        ->assertSeeText('Your Vacation Requests')
        ->assertSeeText('New vacation request')
        ->assertSeeText('Your vacation requests will show here.');
});

it('is redirected if not logged in', function () {
    $this->get(route('vacation-requests.index'))
        ->assertRedirect();

    $this->get(route('vacation-requests.create'))
        ->assertRedirect();
});

it('shows the user\'s vacation request', function () {
    $user = User::factory()->create();
    $this->be($user);

    $vacationRequest = $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    $this->get(route('vacation-requests.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndex::class)
        ->assertSeeText('Your Vacation Requests')
        ->assertSeeText($vacationRequest->start_date)
        ->assertSeeText($vacationRequest->end_date)
        ->assertSeeText($vacationRequest->reason)
        ->assertSeeText('Pending');
});

it('doesn\'t show another user\'s vacation request', function () {
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();
    $this->be($user);

    $vacationRequest = $anotherUser->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    $this->get(route('vacation-requests.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndex::class)
        ->assertSeeText('Your Vacation Requests')
        ->assertDontSeeText($vacationRequest->start_date)
        ->assertDontSeeText($vacationRequest->end_date)
        ->assertDontSeeText($vacationRequest->reason)
        ->assertDontSeeText('Pending');
});

it('shows the vacation request create page', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->get(route('vacation-requests.create'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowCreate::class)
        ->assertSeeText('New Vacation Request')
        ->assertSeeText('Start Date')
        ->assertSeeText('End Date')
        ->assertSeeText('Reason')
        ->assertSeeText('Will you be leaving Phoenix?')
        ->assertSeeText('Cancel')
        ->assertSeeText('Submit');
});

it('can submit a vacation request', function () {
    $user = User::factory()->create();
    $this->be($user);

    $this->get(route('vacation-requests.create'));

    Notification::fake();

    $response = Livewire::test(ShowCreate::class)
        ->set('reason', 'Automatic testing')
        ->set('leaving', '0')
        ->set('start_date', Carbon::tomorrow())
        ->set('end_date', Carbon::tomorrow()->addWeek())
        ->call('submit');

    $vacationRequest = VacationRequest::query()
        ->where('user_id', $user->id)
        ->where('reason', 'Automatic testing')
        ->where('leaving', false)
        ->where('start_date', Carbon::tomorrow())
        ->where('end_date', Carbon::tomorrow()->addWeek());

    $this->assertTrue($vacationRequest->exists());

    Notification::assertSentTo(
        [$vacationRequest->first()], NewVacationRequest::class
    );

    $response->assertredirect(route('vacation-requests.index'))
        ->assertSessionHas('alert', ['type' => 'success', 'message' => 'Vacation request successfully submitted!']);
});

test('start date is required', function () {
    Livewire::test(ShowCreate::class)
        ->set('reason', 'Reason')
        ->call('submit')
        ->assertHasErrors(['start_date' => 'required']);
});
