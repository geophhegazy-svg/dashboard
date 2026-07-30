<?php

declare(strict_types=1);

namespace App\Core\Workflow;

use App\Core\Workflow\Contracts\TransactionManagerInterface;
use App\Core\Workflow\Pipeline\WorkflowExecutor;

final readonly class WorkflowExecutorFactory
{
    public function __construct(
        private TransactionManagerInterface $transactionManager,
    ) {}

    public function create(
        AbstractWorkflow $workflow,
    ): WorkflowExecutor {
        return new WorkflowExecutor(
            $workflow,
            $this->transactionManager,
        );
    }
}
