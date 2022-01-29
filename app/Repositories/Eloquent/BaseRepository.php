<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Object
     */
    protected Object $model;

    public function __construct(Object $model)
    {
        $this->model = $model;
    }
}
