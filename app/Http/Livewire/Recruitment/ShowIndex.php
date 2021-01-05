<?php

namespace App\Http\Livewire\Recruitment;

use App\Models\Application;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowIndex extends Component
{
    use WithPagination;

    public function paginationView(): string
    {
        return 'vendor.livewire.pagination-links';
    }

    public function render(): View
    {
        return view('livewire.recruitment.index', [
            'applications' => Application::latest()->paginate(10),
        ])->extends('layouts.app');
    }
}
