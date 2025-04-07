<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskInterface
{
    protected $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getAll($data)
    {
        $searchKeyword = isset($data['keyword']) ? ($data['keyword'] != '' ? $data['keyword'] : null) : null;
        $statusId = isset($data['status_id']) ? $data['status_id'] : null;
        $ordering = isset($data['ordering']) ? $data['ordering'] : null;
        $field = isset($data['field']) ? $data['field'] : 'created_at';
        $perPage = isset($data['per_page']) ? $data['per_page'] : 10;

        return $this->model->with('user', 'images')
            ->where('created_by', Auth::user()->id)
            ->when(isset($searchKeyword), function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('title', 'LIKE', "%{$searchKeyword}%");
                });
            })
            ->when(isset($statusId), function ($query) use ($statusId) {
                $query->where('status_id', $statusId);
            })
            ->when(isset($ordering), function ($query) use ($ordering, $field) {
                $query->orderBy($field, $ordering);
            })
            ->paginate($perPage);
    }

    public function getById($id)
    {
        return $this->model->with('user', 'images')->findOrFail($id);
    }

    public function store($data)
    {
        $data['created_by'] = Auth::user()->id;
        $formData = $this->model->create($data);

        return $formData;
    }

    public function update($data, $task)
    {
        $task->update($data);

        return $task;
    }

    public function delete($task)
    {
        return $task->delete();
    }

    public function markStatus($data)
    {
        $task = $this->model->findOrFail($data['id']);

        return $task->update(['status_id' => $data['status_id']]);
    }
}
