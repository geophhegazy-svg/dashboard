<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Application\Actions\CompleteTaskAction;

final readonly class CompleteTaskWorkflow
{
    public function __construct(
        private CompleteTaskAction $completeTask,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        return $this->completeTask->execute(
            $task,
        );
    }
}
