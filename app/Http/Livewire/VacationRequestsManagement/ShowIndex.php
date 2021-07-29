<?php

namespace App\Http\Livewire\VacationRequestsManagement;

use App\Mail\LeaveRequestApproved;
use App\Models\VacationRequest;
use Illuminate\Support\Facades\Auth;
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
        $vacation_request = VacationRequest::find($id);

        if ($vacation_request->handled_by) {
            session()->now('alert', ['type' => 'danger', 'message' => 'This vacation request has already been handled.']);
        }

        if (!$vacation_request->handled_by) {
            $vacation_request->handled_by = Auth::id();
            $vacation_request->save();

            if (!$vacation_request->leaving) {
                session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? "Unknown User") . '\'s vacation request successfully marked as seen!']);
            }

            if ($vacation_request->leaving) {
                Mail::to([[
                    'email' => $vacation_request->user->email,
                    'name' => $vacation_request->user->username
                ]])->queue(new LeaveRequestApproved($vacation_request->user));

                $vacation_request->user->delete();

                session()->now('alert', ['type' => 'success', 'message' => 'Request to leave successfully processed, and the PhoenixBase account has been deleted.']);
            }
        }
    }

    public function cancel(int $id): void
    {
        $vacation_request = VacationRequest::find($id);

        if ($vacation_request->deleted_at) {
            session()->now('alert', ['type' => 'danger', 'message' => 'This vacation request has already been cancelled.']);
        }

        if (!$vacation_request->deleted_at) {
            $vacation_request->delete();

            session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? "Unknown User") . '\'s vacation request successfully cancelled!']);
        }
    }
}
