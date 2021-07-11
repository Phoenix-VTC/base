<?php

namespace App\Http\Livewire\GameData\Companies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class Datatable extends DataTableComponent
{
    public bool $columnSelect = true;

    public function query(): Builder
    {
        return Company::query()
            ->when($this->getFilter('game_id'), fn ($query, $value) => $query->where('game_id', $value));
    }

    public function columns(): array
    {
        return [
            Column::make('Id')
                ->searchable()
                ->sortable(),

            Column::make('Name')
                ->searchable()
                ->sortable(),

            Column::make('Category')
                ->searchable()
                ->sortable(),

            Column::make('Specialization')
                ->searchable()
                ->sortable(),

            Column::make('Dlc')
                ->searchable()
                ->sortable(),

            Column::make('Mod')
                ->searchable()
                ->sortable(),

            Column::make('Game', 'game_id')
                ->searchable()
                ->sortable()
                ->format(function ($value) {
                    if ($value === 1) {
                        return 'ETS';
                    }

                    if ($value === 2) {
                        return 'ATS';
                    }

                    return 'Unknown';
                }),

            Column::make('Created At')
                ->sortable(),

            Column::make('Updated At')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            'game_id' => Filter::make('Game')
                ->select([
                    '' => 'Any',
                    1 => 'Euro Truck Simulator',
                    2 => 'American Truck Simulator',
                ]),
        ];
    }

    public function getTableRowUrl($row): string
    {
        return route('game-data.companies.edit', $row);
    }
}
