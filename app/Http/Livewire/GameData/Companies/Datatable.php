<?php

namespace App\Http\Livewire\GameData\Companies;

use App\Models\Company;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Datatable extends LivewireDatatable
{
    public $model = Company::class;

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->filterable()
                ->searchable(),

            Column::name('name')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('category')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('specialization')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('dlc')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('mod')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::callback(['game_id'], function (int $game_id) {
                if ($game_id === 1) {
                    return 'ETS';
                }

                if ($game_id === 2) {
                    return 'ATS';
                }

                return 'Unknown';
            })->label('Game'),

            DateColumn::name('created_at')
                ->filterable(),

            DateColumn::name('updated_at')
                ->filterable(),

            Column::delete(),
        ];
    }
}
