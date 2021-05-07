<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowIndexPage extends Component
{
    public Collection $downloads;

    public function mount(): void
    {
        $this->downloads = Download::all();
    }

    public function render()
    {
        return view('livewire.downloads-management.index-page')->extends('layouts.app');
    }
}
