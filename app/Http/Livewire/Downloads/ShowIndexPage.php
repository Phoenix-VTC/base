<?php

namespace App\Http\Livewire\Downloads;

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
        $this->downloads = Download::where('image_path', '!=', '')
            ->where('file_path', '!=', '')
            ->get();
    }

    public function render()
    {
        return view('livewire.downloads.index-page')->extends('layouts.app');
    }

    public function downloadFile(Download $download): ?StreamedResponse
    {
        $download->update(['download_count' => ++$download->download_count]);

        try {
            return Storage::disk('scaleway')->download($download->file_path, $download->file_name);
        } catch (\Exception $e) {
            session()->now('alert', ['type' => 'danger', 'title' => 'Well, this is awkward.', 'message' => 'Something went wrong while trying to download this file. Please try again later.']);
        }

        return null;
    }
}
