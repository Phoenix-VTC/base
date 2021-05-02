<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class IndexDatatable extends LivewireDatatable
{
    public $exportable = true;

    public $model = User::class;

    public function builder(): Builder
    {
        return User::withTrashed();
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')->filterable()->searchable()->linkTo('users'),

            Column::name('username')->filterable()->searchable(),

            Column::name('email')->filterable()->searchable(),

            BooleanColumn::name('deleted_at')
                ->label('Deleted')
                ->filterable(),

            Column::callback(['id', 'username'], function ($id, $username) {
                return view('livewire.user-management.datatable-components.actions', ['id' => $id, 'username' => $username]);
            }),
        ];
    }
}
