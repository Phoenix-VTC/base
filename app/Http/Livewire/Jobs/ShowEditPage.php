<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Game;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class ShowEditPage extends Component implements HasForms
{
    use InteractsWithForms;

    public Job $job;
    // Form fields
    public $pickup_city;
    public $destination_city;
    public $pickup_company;
    public $destination_company;
    public $cargo;
    public $distance;
    public $load_damage;
    public $estimated_income;
    public $total_income;
    public $comments;

    public function mount(): void
    {
        if (!$this->job->canEdit) {
            abort(403, 'You don\'t have permission to edit this job.');
        }

        $this->form->fill([
            'pickup_city' => $this->job->pickup_city_id,
            'destination_city' => $this->job->destination_city_id,
            'pickup_company' => $this->job->pickup_company_id,
            'destination_company' => $this->job->destination_company_id,
            'cargo' => $this->job->cargo_id,
            'started_at' => $this->job->started_at,
            'distance' => $this->job->distance,
            'load_damage' => $this->job->load_damage,
            'estimated_income' => $this->job->estimated_income,
            'total_income' => $this->job->total_income,
            'comments' => $this->job->comments,
        ]);

        // If job is ATS
        if ($this->job->game_id === 2) {
            // Convert distance to miles
            $this->distance = round($this->job->distance / 1.609);

            // Convert incomes to dollars
            $this->estimated_income = round($this->job->estimated_income / 0.83);
            $this->total_income = round($this->job->total_income / 0.83);
        }
    }

    public function rules(): array
    {
        return [
            'pickup_city' => ['required', 'integer', 'exists:App\Models\City,id'],
            'destination_city' => ['required', 'integer', 'exists:App\Models\City,id'],
            'pickup_company' => ['required', 'integer', 'exists:App\Models\Company,id'],
            'destination_company' => ['required', 'integer', 'exists:App\Models\Company,id'],
            'cargo' => ['required', 'integer', 'exists:App\Models\Cargo,id'],
            'distance' => ['required', 'integer', 'min:1', 'max:5000'],
            'load_damage' => ['required', 'integer', 'min:0', 'max:100'],
            'estimated_income' => ['required', 'integer', 'min:1', 'max:400000'],
            'total_income' => ['required', 'integer', 'min:1', 'max:' . $this->estimated_income],
            'comments' => ['sometimes', 'string'],
        ];
    }

    public function render()
    {
        return view('livewire.jobs.edit-page')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Select::make('pickup_city')
                        ->getSearchResultsUsing(fn($query) => City::dropdownSearch($query))
                        ->getOptionLabelUsing(fn($value) => City::find($value)?->getDropdownName())
                        ->exists(table: City::class, column: 'id')
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('destination_city')
                        ->getSearchResultsUsing(fn($query) => City::dropdownSearch($query))
                        ->getOptionLabelUsing(fn($value) => City::find($value)?->real_name)
                        ->exists(table: City::class, column: 'id')
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('pickup_company')
                        ->columnSpan(1)
                        ->getSearchResultsUsing(fn($query) => Company::dropdownSearch($query))
                        ->getOptionLabelUsing(fn($value) => Company::find($value)?->name)
                        ->exists(table: Company::class, column: 'id')
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('destination_company')
                        ->columnSpan(1)
                        ->getSearchResultsUsing(fn($query) => Company::dropdownSearch($query))
                        ->getOptionLabelUsing(fn($value) => Company::find($value)?->name)
                        ->exists(table: Company::class, column: 'id')
                        ->searchable()
                        ->required(),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\Select::make('cargo')
                                ->getSearchResultsUsing(fn($query) => Cargo::dropdownSearch($query))
                                ->getOptionLabelUsing(fn($value) => Cargo::find($value)?->name)
                                ->exists(table: Cargo::class, column: 'id')
                                ->searchable()
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\TextInput::make('distance')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(5000)
                                ->placeholder(1200)
                                ->hint(fn() => 'In ' . Game::getQualifiedDistanceMetric($this->job->game_id) ?? '??')
                                ->required(),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns()
                        ->schema([
                            Forms\Components\TextInput::make('load_damage')
                                ->label('Cargo damage')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->default(0)
                                ->postfix('%')
                                ->helperText('A value between 0 and 100%')
                                ->required(),
                        ]),

                    Forms\Components\TextInput::make('estimated_income')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(400000)
                        ->prefix(Game::getCurrencySymbol($this->job->game_id) ?? '??')
                        ->placeholder('The original estimate, before any penalties')
                        ->required(),

                    Forms\Components\TextInput::make('total_income')
                        ->numeric()
                        ->minValue(1)
                        ->lte('estimated_income')
                        ->prefix(Game::getCurrencySymbol($this->job->game_id) ?? '??')
                        ->placeholder('Including any in-game penalties')
                        ->required(),

                    Forms\Components\Textarea::make('comments')
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 2,
                        ])
                        ->placeholder('Any notes and/or comments about this delivery'),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $this->job->update([
            'pickup_city_id' => $validatedData['pickup_city'],
            'destination_city_id' => $validatedData['destination_city'],
            'pickup_company_id' => $validatedData['pickup_company'],
            'destination_company_id' => $validatedData['destination_company'],
            'cargo_id' => $validatedData['cargo'],
            'distance' => $validatedData['distance'],
            'load_damage' => $validatedData['load_damage'],
            'estimated_income' => $validatedData['estimated_income'],
            'total_income' => $validatedData['total_income'],
            'comments' => $validatedData['comments'],
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Job successfully edited!']);

        return redirect()->route('jobs.show', $this->job);
    }
}
