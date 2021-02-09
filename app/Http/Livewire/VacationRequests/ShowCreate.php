<?php

namespace App\Http\Livewire\VacationRequests;

use App\Models\VacationRequest;
use App\Notifications\VacationRequest\NewVacationRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ShowCreate extends Component
{
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
            'end_date' => ['exclude_if:leaving,1', 'required_unless:leaving,1', 'date', 'after_or_equal:tomorrow', 'after:start_date', 'after_or_equal:' . Carbon::parse($this->start_date)->addWeek(),
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

    public function render()
    {
        return view('livewire.vacation-requests.create')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $vacation_request = VacationRequest::create([
            'user_id' => Auth::id(),
            'reason' => $validatedData['reason'],
            'leaving' => $validatedData['leaving'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'] ?? null,
        ]);

        $vacation_request->notify(new NewVacationRequest($vacation_request));

        session()->flash('alert', ['type' => 'success', 'message' => 'Vacation request successfully submitted!']);

        return redirect(route('vacation-requests.index'));
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }
}
