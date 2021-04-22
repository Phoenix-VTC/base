<?php

namespace App\Http\Livewire\GameData\Cities;

use App\Models\City;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Datatable extends LivewireDatatable
{
    public $model = City::class;

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->filterable()
                ->searchable(),

            Column::name('real_name')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('name')
                ->filterable()
                ->searchable()
                ->editable(),

            Column::name('country')
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

            NumberColumn::name('x')
                ->editable(),

            NumberColumn::name('z')
                ->editable(),

            DateColumn::name('created_at')
                ->filterable(),

            DateColumn::name('updated_at')
                ->filterable(),

            Column::delete(),
        ];
    }
}
