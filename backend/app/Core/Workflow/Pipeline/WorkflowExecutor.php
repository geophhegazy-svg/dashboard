<?php

declare(strict_types=1);

namespace App\Core\Workflow\Pipeline;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Context\WorkflowContext;
use App\Core\Workflow\Contracts\TransactionManagerInterface;
use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Steps\LegacyWorkflowStep;
use App\Core\Workflow\Steps\TransactionStep;

final readonly class WorkflowExecutor
{
    public function __construct(
        private AbstractWorkflow $workflow,
        private TransactionManagerInterface $transactionManager,
    ) {}

    public function execute(
        mixed ...$arguments
    ): WorkflowResultInterface {

        $context = new WorkflowContext(
            dto: $arguments,
        );

        $context->set(
            'arguments',
            $arguments,
        );

        $pipeline = new WorkflowPipeline([
            new TransactionStep(
                $this->transactionManager,
            ),

            new LegacyWorkflowStep(
                $this->workflow,
            ),
        ]);

        return $pipeline->process(
            $context
        );
    }

    public function executeWorkflow(
        AbstractWorkflow $workflow,
        mixed ...$arguments,
    ): WorkflowResultInterface {

        $context = new WorkflowContext(
            dto: $arguments,
        );

        $context->set(
            'arguments',
            $arguments,
        );

        $pipeline = new WorkflowPipeline([
            new TransactionStep(
                $this->transactionManager,
            ),

            new LegacyWorkflowStep(
                $workflow,
            ),
        ]);

        return $pipeline->process(
            $context
        );
    }
}
