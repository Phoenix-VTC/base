<?php

namespace App\Http\Livewire\VacationRequestsManagement;

use App\Mail\LeaveRequestApproved;
use App\Models\VacationRequest;
use App\Notifications\VacationRequestMarkedAsSeen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowIndex extends Component
{
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
        $vacation_request = VacationRequest::query()->find($id);

        // Return if the vacation request is already handled
        if ($vacation_request->handled_by) {
            session()->now('alert', ['type' => 'danger', 'message' => 'This vacation request has already been handled.']);

            return;
        }

        // Handle the vacation request
        $vacation_request->handled_by = Auth::id();
        $vacation_request->save();

        Cache::forget('vacation_request_count');

        // Send the user a notification if not leaving, and return
        if (!$vacation_request->leaving) {
            $vacation_request->user->notify(new VacationRequestMarkedAsSeen);

            session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? 'Unknown User') . '\'s vacation request successfully marked as seen!']);

            return;
        }

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
        $vacation_request = VacationRequest::query()->withTrashed()->find($id);

        if ($vacation_request->deleted_at) {
            session()->now('alert', ['type' => 'danger', 'message' => 'This vacation request has already been cancelled.']);

            return;
        }

        $vacation_request->delete();

        session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? 'Unknown User') . '\'s vacation request successfully cancelled!']);
    }
}
