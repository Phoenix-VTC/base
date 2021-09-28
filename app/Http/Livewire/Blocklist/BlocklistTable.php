<?php

namespace App\Http\Livewire\Blocklist;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Blocklist;

class BlocklistTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Id'),

            Column::make('Usernames')
                ->searchable()
                ->format(function ($value) {
                    return implode(', ', $value);
                }),

            Column::make('Emails')
                ->searchable()
                ->format(function ($value) {
                    return implode(', ', $value);
                }),

            Column::make('Created At'),

            Column::make('Active', 'deleted_at')
                ->format(function ($value) {
                    return $value ? 'No' : 'Yes';
                }),
        ];
    }

    public function query(): Builder
    {
        return Blocklist::query();
    }

    public function getTableRowUrl($row): string
    {
        return route('user-management.blocklist.show', $row);
    }
}
