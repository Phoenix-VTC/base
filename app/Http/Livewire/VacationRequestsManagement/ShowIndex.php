<?php

namespace App\Http\Livewire\VacationRequestsManagement;

use App\Mail\LeaveRequestApproved;
use App\Models\VacationRequest;
use App\Notifications\VacationRequestMarkedAsSeen;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowIndex extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public function paginationView(): string
    {
        return 'vendor.livewire.pagination-links';
    }

    public function render(): View
    {
        $vacation_requests = VacationRequest::withTrashed()
            ->with(['user', 'staff'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.vacation-requests-management.index', [
            'vacation_requests' => $vacation_requests,
        ])->extends('layouts.app');
    }

    public function markAsSeen(int $id): void
    {
        $vacation_request = VacationRequest::withTrashed()->find($id);

        $this->authorize('markAsSeen', $vacation_request);

        $vacation_request->update([
            'handled_by' => Auth::id(),
        ]);

        Cache::forget('vacation_request_count');

        // Send the user a notification if not leaving
        if (!$vacation_request->leaving) {
            $vacation_request->user->notify(new VacationRequestMarkedAsSeen);

            session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? "Unknown User") . '\'s vacation request successfully marked as seen!']);

            return;
        }

        // If the code reaches this point, the user is leaving Phoenix.
        // Send the user an email about their leaving request, and handle the account deletion
        Mail::to([[
            'email' => $vacation_request->user->email,
            'name' => $vacation_request->user->username
        ]])->queue(new LeaveRequestApproved($vacation_request->user));

        $vacation_request->user->delete();

        session()->now('alert', ['type' => 'success', 'message' => 'Request to leave successfully processed, and their PhoenixBase account has been deleted.']);
    }

    public function cancel(int $id): void
    {
        $vacation_request = VacationRequest::withTrashed()->find($id);

        $this->authorize('cancel', $vacation_request);

        $vacation_request->update([
            'handled_by' => Auth::id(),
            'deleted_at' => now(),
        ]);

        $vacation_request->delete();

        session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? "Unknown User") . '\'s vacation request successfully cancelled!']);
    }
}
