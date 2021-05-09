<?php

namespace App\Observers;

use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadObserver
{
    /**
     * Handle the Download "deleted" event.
     *
     * @param \App\Models\Download $download
     * @return void
     */
    public function deleted(Download $download)
    {
        Storage::disk('scaleway')->deleteDirectory("downloads/$download->id");
    }

    /**
     * Handle the Download "force deleted" event.
     *
     * @param \App\Models\Download $download
     * @return void
     */
    public function forceDeleted(Download $download)
    {
        Storage::disk('scaleway')->deleteDirectory("downloads/$download->id");
    }
}
