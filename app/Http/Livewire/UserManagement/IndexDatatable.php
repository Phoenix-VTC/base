<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class IndexDatatable extends DataTableComponent
{
    public bool $columnSelect = true;

    public function query(): Builder
    {
        return User::withTrashed()->with('application')
            ->when($this->getFilter('account_activated'), fn ($query, $value) => $value === 'yes' ? $query->whereNull('welcome_valid_until') : $query->whereNotNull('welcome_valid_until'))
            ->when($this->getFilter('account_deleted'), fn ($query, $value) => $value === 'yes' ? $query->whereNotNull('deleted_at') : $query->whereNull('deleted_at'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id')
                ->searchable()
                ->sortable(),

            Column::make('Username')
                ->searchable()
                ->sortable(),

            Column::make('Email')
                ->searchable()
                ->sortable(),

            Column::make('Application ID', 'application.uuid'),

            Column::make('Account Activated', 'welcome_valid_until')
                ->sortable()
                ->format(function ($value) {
                    return $value ? 'No' : 'Yes';
                }),

            Column::make('Created At')
                ->sortable(),

            Column::make('Deleted At')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            'account_activated' => Filter::make('Account Activated')
                ->select([
                    '' => 'Any',
                    'yes' => 'Yes',
                    'no' => 'No',
                ]),

            'account_deleted' => Filter::make('Account Deleted')
                ->select([
                    '' => 'Any',
                    'yes' => 'Yes',
                    'no' => 'No',
                ]),
        ];
    }

    public function getTableRowUrl($row): string
    {
        return route('users.profile', $row);
    }
}
