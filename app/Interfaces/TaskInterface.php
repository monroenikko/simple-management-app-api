<?php

namespace App\Interfaces;

interface TaskInterface
{
    /**
     * Get all tasks with user information.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll($request);

    public function store($request);

    public function getById($id);

    public function update($request, $id);

    public function delete($id);

    public function markStatus($data);
}
