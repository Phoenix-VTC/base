<?php

namespace App\Http\Livewire\GameData\Cargos;

use App\Models\Cargo;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Datatable extends LivewireDatatable
{
    public $model = Cargo::class;

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

            Column::name('dlc')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('mod')
                ->filterable()
                ->searchable()
                ->editable(),

            NumberColumn::name('weight'),

            Column::callback(['game_id'], function (int $game_id) {
                if ($game_id === 1) {
                    return 'ETS';
                }

                if ($game_id === 2) {
                    return 'ATS';
                }

                return 'Unknown';
            })->label('Game'),

            BooleanColumn::name('world_of_trucks'),

            DateColumn::name('created_at')
                ->filterable(),

            DateColumn::name('updated_at')
                ->filterable(),

            Column::delete(),
        ];
    }
}
