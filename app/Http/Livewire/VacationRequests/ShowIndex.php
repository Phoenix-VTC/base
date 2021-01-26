<?php

namespace App\Http\Livewire\VacationRequests;

use App\Models\VacationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndex extends Component
{
    public $showModal = false;

    private $vacation_requests;

    public string $start_date = '';
    public string $end_date = '';
    public string $reason = '';
    public string $leaving = '';

    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'after_or_equal:tomorrow',
                Rule::unique('vacation_requests')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
            'end_date' => ['exclude_if:leaving,1', 'required_unless:leaving,1', 'date', 'after_or_equal:tomorrow',
                Rule::unique('vacation_requests')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
            'reason' => ['required', 'min:3'],
            'leaving' => ['required', 'boolean',
                Rule::unique('vacation_requests')->where(function ($query) {
                    return $query->where('user_id', Auth::id())->where('leaving', 1)->whereNull('handled_by');
                })
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.required_unless' => 'The end date field is required unless you are leaving.',
            'start_date.unique' => 'You have already submitted a vacation request for this date.',
            'end_date.unique' => 'You have already submitted a vacation request for this date.',
            'leaving.unique' => 'You have already submitted a request to leave Phoenix.',
        ];
    }

    public function mount(): void
    {
        $this->vacation_requests = VacationRequest::where('user_id', Auth::id())->with('staff');
    }

    public function render(): View
    {
        return view('livewire.vacation-requests.index', ['vacation_requests' => $this->vacation_requests->get()])->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $this->vacation_requests->create([
            'user_id' => Auth::id(),
            'reason' => $validatedData['reason'],
            'leaving' => $validatedData['leaving'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'] ?? null,
        ]);

        unset($this->start_date, $this->end_date, $this->reason, $this->leaving);
        $this->showModal = false;

        session()->flash('alert', ['type' => 'success', 'message' => 'Vacation request successfully submitted!']);
    }
}
