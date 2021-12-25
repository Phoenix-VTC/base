<?php

namespace App\Http\Livewire\VacationRequests;

use App\Models\VacationRequest;
use App\Notifications\VacationRequest\NewVacationRequest;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class ShowCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public $start_date;
    public $end_date;
    public $reason;
    public $leaving;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function messages(): array
    {
        return [
            'end_date.required_unless' => 'The end date field is required unless you are leaving.',
            'start_date.unique' => 'You have already submitted a vacation request for this date.',
            'end_date.unique' => 'You have already submitted a vacation request for this date.',
            'end_date.after_or_equal' => 'Vacation requests must last at least a week. For shorter inactivity periods, no request is needed.',
            'leaving.unique' => 'You have already submitted a request to leave Phoenix.',
        ];
    }

    public function render()
    {
        return view('livewire.vacation-requests.create')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\Toggle::make('leaving')
                                ->required()
                                ->inline(false)
                                ->label('Will you be leaving Phoenix?')
                                ->helperText('Please note that we will not re-activate accounts once they have been terminated.')
                                ->offIcon('heroicon-s-x')
                                ->onIcon('heroicon-s-check')
                                ->reactive() // Reload the component when it updates, so that the `hidden` functions work
                                ->unique(table: 'vacation_requests', callback: function (Unique $rule) {
                                    return $rule->where('user_id', Auth::id())
                                        ->where('leaving', 1)
                                        ->whereNull('handled_by');
                                })
                        ]),

                    Forms\Components\DatePicker::make('start_date')
                        ->required()
                        ->hidden(fn(Closure $get) => $get('leaving')) // Hide if leaving
                        ->minDate(now()->addDay())
                        ->afterOrEqual('tomorrow')
                        ->unique(table: 'vacation_requests', callback: function (Unique $rule) {
                            return $rule->where('user_id', Auth::id());
                        }),

                    Forms\Components\DatePicker::make('end_date')
                        ->required()
                        ->hidden(fn(Closure $get) => $get('leaving')) // Hide if leaving
                        ->minDate(now()->addDay())
                        ->afterOrEqual(fn(Closure $get) => Carbon::parse($get('start_date'))->addWeek()) // Must be at least a week after the start date
                        ->unique(table: 'vacation_requests', callback: function (Unique $rule) {
                            return $rule->where('user_id', Auth::id());
                        }),

                    Forms\Components\Textarea::make('reason')
                        ->required()
                        ->rows(5)
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 2,
                        ])
                        ->placeholder('Please specify the reason of this vacation or leave request'),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $vacation_request = VacationRequest::create([
            'user_id' => Auth::id(),
            'reason' => $validatedData['reason'],
            'leaving' => $validatedData['leaving'],
            'start_date' => $validatedData['start_date'] ?? null,
            'end_date' => $validatedData['end_date'] ?? null,
        ]);

        Cache::forget('vacation_request_count');

        $vacation_request->notify(new NewVacationRequest($vacation_request));

        session()->flash('alert', ['type' => 'success', 'message' => 'Vacation request successfully submitted!']);

        return redirect(route('vacation-requests.index'));
    }
}
