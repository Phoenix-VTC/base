<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class IndexDatatable extends LivewireDatatable
{
    public $exportable = true;

    public function builder(): Builder
    {
        return User::query()
            ->with('roles');
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')->filterable()->searchable(),

            Column::name('username')->filterable()->searchable()->view('livewire.user-management.datatable-components.username-field'),

            Column::name('email')->filterable()->searchable(),

            Column::name('roles.name')->label('Roles')->filterable(),

            Column::name('steam_id')->searchable()->filterable()->searchable(),

            Column::name('truckersmp_id')->searchable()->filterable()->searchable(),

            DateColumn::name('created_at')->filterable(),

            DateColumn::name('deleted_at'),
        ];
    }
}
