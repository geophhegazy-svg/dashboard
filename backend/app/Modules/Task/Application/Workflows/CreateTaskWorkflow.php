<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Models\Task;
use App\Modules\Task\Application\Actions\CreateTaskAction;

final readonly class CreateTaskWorkflow
{
    public function __construct(
        private CreateTaskAction $createTask,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        return $this->createTask->execute(
            $task,
        );
    }
}
