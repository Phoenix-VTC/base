<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var object
     */
    protected Object $model;

    public function __construct(Object $model)
    {
        $this->model = $model;
    }
}
