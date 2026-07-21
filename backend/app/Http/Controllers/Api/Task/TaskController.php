<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Modules\Task\Application\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $service,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(
            $this->service->paginate()
        );
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        return (new TaskResource(
            $this->service->create(
                $request->validated()
            )
        ))->response()->setStatusCode(201);
    }

    public function update(
        UpdateTaskRequest $request,
        Task $task
    ): TaskResource {

        return new TaskResource(
            $this->service->update(
                $task,
                $request->validated()
            )
        );
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->service->delete($task);

        return response()->json(
            null,
            204
        );
    }
}
