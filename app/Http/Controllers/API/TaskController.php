<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Task\MarkStatusRequest;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->getAllTasks($request);
    }

    public function store(TaskStoreRequest $request)
    {
        return $this->service->createTask($request);
    }

    public function show(Task $task)
    {
        return $this->service->getById($task->id);
    }

    public function update(TaskStoreRequest $request, Task $task)
    {
        return $this->service->updateTask($request, $task);
    }

    public function destroy(Task $task)
    {
        return $this->service->deleteTask($task);
    }

    public function markStatus(MarkStatusRequest $request)
    {
        return $this->service->markStatus($request->validated());
    }
}
