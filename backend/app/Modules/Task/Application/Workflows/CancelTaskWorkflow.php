<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Application\Actions\CancelTaskAction;

final readonly class CancelTaskWorkflow
{
    public function __construct(
        private CancelTaskAction $cancelTask,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        return $this->cancelTask->execute(
            $task,
        );
    }
}
