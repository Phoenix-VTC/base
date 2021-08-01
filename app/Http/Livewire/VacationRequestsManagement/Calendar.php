<?php

namespace App\Http\Livewire\VacationRequestsManagement;

use App\Models\VacationRequest;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Livewire\Redirector;

class Calendar extends LivewireCalendar
{
    public function events(): Collection
    {
        return VacationRequest::where('leaving', false)
            ->with(['user', 'staff'])
            ->get()
            ->map(function (VacationRequest $vacationRequest) {
                return [
                    'id' => $vacationRequest->id,
                    'title' => $vacationRequest->user->username ?? 'Deleted User',
                    'description' => $vacationRequest->staff()->exists() ? 'Handled by ' . $vacationRequest->staff->username : '',
                    'date' => $vacationRequest->start_date,
                ];
            });
    }

    public function onEventClick($eventId): Redirector
    {
        $userId = VacationRequest::findOrFail($eventId)->user_id;

        return redirect()->route('users.profile', $userId);
    }
}