<?php

namespace App\Repositories;

use App\Models\Status;

class StatusRepository
{
    protected $model;

    public function __construct(Status $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
