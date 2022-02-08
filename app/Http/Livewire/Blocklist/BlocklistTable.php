<?php

namespace App\Http\Livewire\Blocklist;

use App\Models\Blocklist;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BlocklistTable extends DataTableComponent
{
    public function columns(): array
    {
        return [
            Column::make('Id')
                ->sortable(),

            Column::make('Usernames')
                ->format(function ($value) {
                    return implode(', ', $value);
                }),

            Column::make('Emails')
                ->format(function ($value) {
                    return implode(', ', $value);
                }),

            Column::make('Created At')
                ->sortable(),

            Column::make('Active', 'deleted_at')
                ->format(function ($value) {
                    return $value ? 'No' : 'Yes';
                }),
        ];
    }

    public function query(): Builder
    {
        return Blocklist::query()
            ->when($this->getFilter('search'), fn ($query, $term) => $query->likeSearch($term))
            ->latest();
    }

    public function getTableRowUrl($row): string
    {
        return route('user-management.blocklist.show', $row);
    }
}
