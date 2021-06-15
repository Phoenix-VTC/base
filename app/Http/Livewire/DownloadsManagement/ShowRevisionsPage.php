<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Livewire\Component;

class ShowRevisionsPage extends Component
{
    public Download $download;

    public function render()
    {
        return view('livewire.downloads-management.revisions-page')->extends('layouts.app');
    }
}
