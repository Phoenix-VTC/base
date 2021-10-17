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

test('start and end date must be after or equal to tomorrow', function () {
    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::yesterday())
        ->set('end_date', Carbon::yesterday())
        ->call('submit')
        ->assertHasErrors(['start_date' => 'after_or_equal', 'end_date' => 'after_or_equal']);
});

test('start and end date must be unique to user', function () {
    $user = User::factory()->create();
    $this->be($user);

    $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::tomorrow())
        ->set('end_date', Carbon::tomorrow()->addWeek())
        ->call('submit')
        ->assertHasErrors(['start_date' => 'unique', 'end_date' => 'unique']);
});

test('end date is required when not leaving', function () {
    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::tomorrow())
        ->set('leaving', '0')
        ->call('submit')
        ->assertHasErrors(['end_date' => 'required_unless']);
});

test('end date is not required when leaving', function () {
    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::tomorrow())
        ->set('leaving', '1')
        ->call('submit')
        ->assertHasNoErrors(['end_date']);
});

test('end date must be after start date', function () {
    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::tomorrow())
        ->set('end_date', Carbon::tomorrow())
        ->call('submit')
        ->assertHasErrors(['end_date' => 'after']);
});

test('end date must be at least a week after the start date', function () {
    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::tomorrow())
        ->set('end_date', Carbon::tomorrow()->addDays(3))
        ->call('submit')
        ->assertHasErrors(['end_date' => 'after_or_equal']);
});

test('reason is required', function () {
    Livewire::test(ShowCreate::class)
        ->call('submit')
        ->assertHasErrors(['reason' => 'required']);
});

test('reason must be at least 3 characters', function () {
    Livewire::test(ShowCreate::class)
        ->set('reason', 'a')
        ->call('submit')
        ->assertHasErrors(['reason' => 'min']);
});

test('leaving is required', function () {
    Livewire::test(ShowCreate::class)
        ->call('submit')
        ->assertHasErrors(['leaving' => 'required']);
});

test('leaving must be boolean', function () {
    Livewire::test(ShowCreate::class)
        ->set('leaving', 'NotABoolean')
        ->call('submit')
        ->assertHasErrors(['leaving' => 'boolean']);
});

test('a user can only have one unhandled leaving request', function () {
    $user = User::factory()->create();
    $this->be($user);

    $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => true,
    ]);

    Livewire::test(ShowCreate::class)
        ->set('leaving', '1')
        ->call('submit')
        ->assertHasErrors(['leaving' => 'unique']);
});

test('a user can have multiple leaving requests, if all except current handled', function () {
    $user = User::factory()->create();
    $staff = User::factory()->create();
    $this->be($user);

    $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => true,
        'handled_by' => $staff->id,
    ]);

    Livewire::test(ShowCreate::class)
        ->set('leaving', '1')
        ->call('submit')
        ->assertHasNoErrors(['leaving']);
});
