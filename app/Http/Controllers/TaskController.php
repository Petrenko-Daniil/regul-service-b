<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use App\Models\Task;
use LogicException;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::query()
            ->paginate(20);
        return response()->json(TaskResource::collection($tasks));
    }

    public function show(Task $task)
    {
        $task->load('category');
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return response(new TaskResource($task), 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return response(null, 204);
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
        } catch (LogicException $exception){
            return response($exception->getMessage(), 500);
        }
        return response(null, 204);
    }
}
