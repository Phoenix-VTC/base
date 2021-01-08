<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class IndexDatatable extends LivewireDatatable
{
    public $model = User::class;
    public $exportable = true;

    public function columns(): array
    {
        return [
            NumberColumn::name('id')->filterable()->searchable(),

            Column::name('username')->filterable()->searchable()->view('livewire.user-management.datatable-components.username-field'),

            Column::name('email')->truncate()->filterable()->searchable(),

            Column::name('steam_id')->searchable()->filterable()->searchable(),

            Column::name('truckersmp_id')->searchable()->filterable()->searchable(),

            DateColumn::name('created_at')->filterable(),

            DateColumn::name('deleted_at'),
        ];
    }
}
