<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Application\Actions\StartTaskAction;

final readonly class StartTaskWorkflow
{
    public function __construct(
        private StartTaskAction $startTask,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        return $this->startTask->execute(
            $task,
        );
    }
}
