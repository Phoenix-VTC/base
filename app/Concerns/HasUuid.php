<?php

namespace App\Concerns;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Hook into the models boot method.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // Assign UUID when model is being created
            $model->uuid = Str::uuid();
        });
    }
}
