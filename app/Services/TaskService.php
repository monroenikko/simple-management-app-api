<?php

namespace App\Services;

use App\Http\Resources\Task\ShowResource;
use App\Repositories\TaskRepository;
use App\Traits\ResponseApi;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TaskService
{
    use ResponseApi;

    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTasks($data)
    {
        try {

            $res = new \App\Http\Resources\Task\ShowAllResource($this->repository->getAll($data));

            return $this->success(
                'Data Successfully Fetched.',
                Response::HTTP_OK,
                $res
            );
        } catch (Exception $e) {
            dd($e);

            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function getById($id)
    {
        try {
            $res = $this->repository->getById($id);

            return $this->success(
                'Data Successfully Fetched.',
                Response::HTTP_OK,
                new ShowResource($res)
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function createTask($data)
    {
        DB::beginTransaction();
        try {

            $res = $this->repository->store($data->validated());
            if ($data->hasFile('images')) {
                foreach ($data->file('images') as $image) {
                    $imagePath = $image->store('tasks/images', 'public');
                    $imagePaths[] = $imagePath;

                    $res->images()->create([
                        'path' => $imagePath,
                    ]);
                }
            }
            DB::commit();

            return $this->success(
                'Tasl Successfully Created.',
                Response::HTTP_CREATED,
                $res
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateTask($data, $task)
    {
        DB::beginTransaction();
        try {
            $res = $this->repository->update($data->validated(), $task);
            if ($data->hasFile('images')) {
                foreach ($data->file('images') as $image) {
                    $imagePath = $image->store('tasks/images', 'public');
                    $imagePaths[] = $imagePath;

                    $res->images()->create([
                        'path' => $imagePath,
                    ]);
                }
            }
            DB::commit();

            return $this->success(
                'Task Successfully Updated.',
                Response::HTTP_OK,
                new ShowResource($res)
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function markStatus($data)
    {
        DB::beginTransaction();
        try {
            $res = $this->repository->markStatus($data);
            DB::commit();

            return $this->success(
                'Task Successfully Marked.',
                Response::HTTP_OK,
                $res
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteTask($task)
    {
        DB::beginTransaction();
        try {
            $res = $this->repository->delete($task);
            DB::commit();

            return $this->success(
                'Task Successfully Deleted.',
                Response::HTTP_OK,
                $res
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
