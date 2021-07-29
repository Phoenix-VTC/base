<?php

namespace App\Http\Livewire\VacationRequestsManagement;

use App\Models\VacationRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndex extends Component
{
    public Collection $vacation_requests;

    public function mount(): void
    {
        $this->vacation_requests = VacationRequest::withTrashed()
            ->get()
            ->sortDesc();
    }

    public function render(): View
    {
        return view('livewire.vacation-requests-management.index')->extends('layouts.app');
    }

    public function markAsSeen(int $id): void
    {
        $vacation_request = $this->vacation_requests->find($id);

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
                $vacation_request->user->delete();

                session()->now('alert', ['type' => 'success', 'message' => 'Request to leave successfully processed, and the PhoenixBase account has been deleted.']);
            }
        }
    }

    public function cancel(int $id): void
    {
        $vacation_request = $this->vacation_requests->find($id);

        if ($vacation_request->deleted_at) {
            session()->now('alert', ['type' => 'danger', 'message' => 'This vacation request has already been cancelled.']);
        }

        if (!$vacation_request->deleted_at) {
            $vacation_request->delete();

            session()->now('alert', ['type' => 'success', 'message' => ($vacation_request->user->username ?? "Unknown User") . '\'s vacation request successfully cancelled!']);
        }
    }
}
