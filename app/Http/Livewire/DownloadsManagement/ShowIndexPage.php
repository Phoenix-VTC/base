<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function downloadFile(Download $download): StreamedResponse
    {
        return Storage::disk('scaleway')->download($download->file_path, $download->file_name);
    }
}
