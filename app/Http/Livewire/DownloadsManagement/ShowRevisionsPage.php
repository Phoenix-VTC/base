<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowRevisionsPage extends Component
{
    use AuthorizesRequests;
    public Download $download;

    public function mount()
    {
        $this->authorize('viewRevisionHistory', Download::class);
    }

    public function render()
    {
        return view('livewire.downloads-management.revisions-page')->extends('layouts.app');
    }
}
