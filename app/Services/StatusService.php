<?php

namespace App\Services;

use App\Repositories\StatusRepository;
use App\Traits\ResponseApi;
use Exception;
use Illuminate\Http\Response;

class StatusService
{
    use ResponseApi;

    protected $repository;

    public function __construct(StatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllStatuses()
    {
        try {
            $res = $this->repository->getAll();

            return $this->success(
                'Data Successfully Fetched.',
                Response::HTTP_OK,
                $res
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
