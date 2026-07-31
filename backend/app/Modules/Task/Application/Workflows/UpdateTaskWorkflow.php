<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Models\Task;
use App\Modules\Task\Application\Actions\UpdateTaskAction;

final readonly class UpdateTaskWorkflow
{
    public function __construct(
        private UpdateTaskAction $updateTask,
    ) {}

    public function execute(
        Task $task,
        array $data,
    ): Task {

        return $this->updateTask->execute(
            $task,
            $data,
        );
    }
}
