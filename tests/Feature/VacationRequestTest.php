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
        ->assertSeeText($vacationRequest->start_date->format('M d, Y'))
        ->assertSeeText($vacationRequest->start_date->format('M d, Y'))
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
        ->assertSeeText('Will you be leaving Phoenix?')
        ->assertSeeText('Start date')
        ->assertSeeText('End date')
        ->assertSeeText('Reason')
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

it('tests the validation rules', function ($field, $value, $rule) {
    Livewire::test(ShowCreate::class)
        ->set($field, $value)
        ->call('submit')
        ->assertHasErrors([$field => $rule]);
})->with([
    'start date is null' => ['start_date', null, 'required'],
    'end date is null' => ['end_date', null, 'required'],
    'reason is null' => ['reason', null, 'required'],
    'start date is before tomorrow' => ['start_date', Carbon::yesterday(), 'after_or_equal'],
    'end date is before tomorrow' => ['end_date', Carbon::yesterday(), 'after_or_equal'],
    'reason is below 3 characters' => ['reason', 'a', 'min'],
    'leaving is not a boolean' => ['leaving', 'not a boolean', 'boolean'],
]);

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
        ->assertHasErrors(['end_date']);
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
        ->assertHasErrors(['end_date' => 'after_or_equal']);
});

test('end date must be at least a week after the start date', function () {
    Livewire::test(ShowCreate::class)
        ->set('start_date', Carbon::tomorrow())
        ->set('end_date', Carbon::tomorrow()->addDays(3))
        ->call('submit')
        ->assertHasErrors(['end_date' => 'after_or_equal']);
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
