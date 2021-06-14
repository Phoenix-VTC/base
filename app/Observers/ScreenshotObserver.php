<?php

namespace App\Observers;

use App\Models\Screenshot;
use Illuminate\Support\Facades\Storage;

class ScreenshotObserver
{
    /**
     * Handle the Screenshot "deleted" event.
     *
     * @param \App\Models\Screenshot $screenshot
     * @return void
     */
    public function deleted(Screenshot $screenshot)
    {
        Storage::disk('scaleway')->delete($screenshot->image_path);
    }

    /**
     * Handle the Screenshot "force deleted" event.
     *
     * @param \App\Models\Screenshot $screenshot
     * @return void
     */
    public function forceDeleted(Screenshot $screenshot)
    {
        Storage::disk('scaleway')->delete($screenshot->image_path);
    }
}
