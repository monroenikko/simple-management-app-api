<?php

namespace App\Interfaces;

interface StatusInterface
{
    /**
     * Get all statuses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStatuses();

    /**
     * Get a status by ID.
     *
     * @param  int  $id
     * @return \App\Models\Status|null
     */
    public function getStatusById($id);
}
