<?php

use App\Http\Livewire\VacationRequestsManagement\Calendar;
use App\Http\Livewire\VacationRequestsManagement\ShowIndex;
use App\Mail\LeaveRequestApproved;
use App\Models\User;
use App\Notifications\VacationRequestMarkedAsSeen;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

it('shows the vacation requests management page', function () {
    $user = User::factory()->create()->assignRole('human resources team');
    $this->be($user);

    $this->get(route('vacation-requests.manage.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowIndex::class)
        ->assertSeeLivewire(Calendar::class)
        ->assertSeeText('Manage Vacation Requests');
});

it('is redirected if not logged in', function () {
    $this->get(route('vacation-requests.manage.index'))
        ->assertRedirect();
});

it('returns 403 if not authorized', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('vacation-requests.manage.index'))
        ->assertForbidden();
});

it('can process a vacation request', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('markAsSeen', $vacationRequest->id)
        ->assertSuccessful()
        ->assertSessionHas('alert', ['type' => 'success', 'message' => "{$user->username}'s vacation request successfully marked as seen!"]);

    $vacationRequest = $vacationRequest->refresh();

    Notification::assertSentTo(
        [$user], VacationRequestMarkedAsSeen::class
    );

    assertEquals($staff->id, $vacationRequest->handled_by);
});

it('cannot process a vacation request if already processed', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'handled_by' => $staff->id,
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('markAsSeen', $vacationRequest->id)
        ->assertForbidden()
        ->assertSeeText('This vacation request has already been handled.');
});

it('can process a leaving request', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Mail::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'reason' => 'Automatic testing',
        'leaving' => true,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('markAsSeen', $vacationRequest->id)
        ->assertSuccessful()
        ->assertSessionHas('alert', ['type' => 'success', 'message' => 'Request to leave successfully processed, and their PhoenixBase account has been deleted.']);

    $vacationRequest = $vacationRequest->refresh();
    $user = $user->refresh();

    Mail::assertQueued(LeaveRequestApproved::class);

    assertEquals($staff->id, $vacationRequest->handled_by);

    assertTrue($user->trashed());
});

it('cannot process a leaving request if already processed', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'handled_by' => $staff->id,
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => true,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('markAsSeen', $vacationRequest->id)
        ->assertForbidden()
        ->assertSeeText('This vacation request has already been handled.');
});

it('can cancel a new vacation request', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('cancel', $vacationRequest->id)
        ->assertSuccessful()
        ->assertSessionHas('alert', ['type' => 'success', 'message' => "{$user->username}'s vacation request successfully cancelled!"]);

    $vacationRequest = $vacationRequest->refresh();

    assertTrue($vacationRequest->trashed());
});

it('can cancel a upcoming vacation request', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'handled_by' => $staff->id,
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('cancel', $vacationRequest->id)
        ->assertSuccessful()
        ->assertSessionHas('alert', ['type' => 'success', 'message' => "{$user->username}'s vacation request successfully cancelled!"]);

    $vacationRequest = $vacationRequest->refresh();

    assertTrue($vacationRequest->trashed());
});

it('can cancel an active vacation request', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'handled_by' => $staff->id,
        'start_date' => Carbon::today(),
        'end_date' => Carbon::today()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(ShowIndex::class)
        ->call('cancel', $vacationRequest->id)
        ->assertSuccessful()
        ->assertSessionHas('alert', ['type' => 'success', 'message' => "{$user->username}'s vacation request successfully cancelled!"]);

    $vacationRequest = $vacationRequest->refresh();

    assertTrue($vacationRequest->trashed());
});

it('cannot cancel a vacation request if already cancelled', function () {
    $staff = User::factory()->create()->assignRole('human resources team');
    $this->be($staff);

    Notification::fake();

    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
        'deleted_at' => Carbon::now(),
    ]);

    Livewire::test(ShowIndex::class)
        ->call('cancel', $vacationRequest->id)
        ->assertForbidden()
        ->assertSeeText('This vacation request has already been cancelled.');
});

it('can click a vacation requests calendar item', function () {
    $user = User::factory()->create();
    $vacationRequest = $user->vacation_requests()->create([
        'start_date' => Carbon::tomorrow(),
        'end_date' => Carbon::tomorrow()->addWeek(),
        'reason' => 'Automatic testing',
        'leaving' => false,
    ]);

    Livewire::test(Calendar::class)
        ->call('onEventClick', $vacationRequest->id)
        ->assertRedirect(route('users.profile', $vacationRequest->user));
});
