<?php

namespace App\Http\Livewire\Jobs\Submit;

use App\Enums\JobStatus;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Game;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowSubmitPage extends Component implements HasForms
{
    use InteractsWithForms;

    public int $game_id;
    // Form fields
    public $pickup_city;
    public $destination_city;
    public $pickup_company;
    public $destination_company;
    public $cargo;
    public $finished_at;
    public $distance;
    public $load_damage;
    public $estimated_income;
    public $total_income;
    public $comments;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.jobs.submit.submit-page')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->columns()
                ->schema([
                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\Select::make('pickup_city')
                                ->columnSpan(1)
                                ->getSearchResultsUsing(function (string $query) {
                                    return City::dropdownSearch($query);
                                })
                                ->getOptionLabelUsing(fn($value) => City::find($value)?->getDropdownName())
                                ->exists(table: City::class, column: 'id')
                                ->searchable()
                                ->required(),

                            Forms\Components\Select::make('destination_city')
                                ->columnSpan(1)
                                ->getSearchResultsUsing(function (string $query) {
                                    return City::query()
                                        ->search($query)
                                        ->limit(10)
                                        ->get()
                                        ->mapWithKeys(function (City $city) {
                                            return [
                                                $city->id => $city->getDropdownName(),
                                            ];
                                        });
                                })
                                ->getOptionLabelUsing(fn($value) => City::find($value)?->real_name)
                                ->exists(table: City::class, column: 'id')
                                ->searchable()
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\Select::make('pickup_company')
                                ->columnSpan(1)
                                ->getSearchResultsUsing(function (string $query) {
                                    return Company::query()
                                        ->search($query)
                                        ->limit(10)
                                        ->pluck('name', 'id');
                                })
                                ->getOptionLabelUsing(fn($value) => Company::find($value)?->name)
                                ->exists(table: Company::class, column: 'id')
                                ->searchable()
                                ->required(),

                            Forms\Components\Select::make('destination_company')
                                ->columnSpan(1)
                                ->getSearchResultsUsing(function (string $query) {
                                    return Company::query()
                                        ->search($query)
                                        ->limit(10)
                                        ->pluck('name', 'id');
                                })
                                ->getOptionLabelUsing(fn($value) => Company::find($value)?->name)
                                ->exists(table: Company::class, column: 'id')
                                ->searchable()
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\Select::make('cargo')
                                ->columnSpan(1)
                                ->getSearchResultsUsing(function (string $query) {
                                    return Cargo::query()
                                        ->search($query)
                                        ->limit(10)
                                        ->pluck('name', 'id');
                                })
                                ->getOptionLabelUsing(fn($value) => Cargo::find($value)?->name)
                                ->exists(table: Cargo::class, column: 'id')
                                ->searchable()
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\DatePicker::make('finished_at')
                                ->columnSpan(1)
                                ->minDate(now()->subDays(7))
                                ->maxDate(now())
                                ->default(now())
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\TextInput::make('distance')
                                ->columnSpan(1)
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(5000)
                                ->placeholder(1200)
                                ->hint(fn() => 'In ' . Game::getQualifiedDistanceMetric($this->game_id) ?? '??')
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\TextInput::make('load_damage')
                                ->label('Cargo damage')
                                ->columnSpan(1)
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->default(0)
                                ->postfix('%')
                                ->helperText('A value between 0 and 100%')
                                ->required(),
                        ]),

                    Forms\Components\TextInput::make('estimated_income')
                        ->columnSpan(1)
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(400000)
                        ->placeholder('The original estimate, before any penalties')
                        ->required(),

                    Forms\Components\TextInput::make('total_income')
                        ->columnSpan(1)
                        ->numeric()
                        ->minValue(1)
                        ->lte('estimated_income')
                        ->placeholder('Including any in-game penalties')
                        ->required(),

                    Forms\Components\Textarea::make('comments')
                        ->columnSpan(2)
                        ->placeholder('Any notes and/or comments about this delivery'),
                ]),

        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $job = Job::create([
            'user_id' => Auth::id(),
            'game_id' => $this->game_id,
            'pickup_city_id' => $validatedData['pickup_city'],
            'destination_city_id' => $validatedData['destination_city'],
            'pickup_company_id' => $validatedData['pickup_company'],
            'destination_company_id' => $validatedData['destination_company'],
            'cargo_id' => $validatedData['cargo'],
            'finished_at' => $validatedData['finished_at'],
            'distance' => $validatedData['distance'],
            'load_damage' => $validatedData['load_damage'],
            'estimated_income' => $validatedData['estimated_income'],
            'total_income' => $validatedData['total_income'],
            'comments' => $validatedData['comments'],
            'status' => JobStatus::Complete,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Job successfully submitted!']);

        return redirect()->route('jobs.show', $job);
    }
}
