<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Create a new record of the model.
     *
     * @param  array  $attributes
     * @return Model
     */
    public function create(array $attributes): Model;
}
