<?php

declare(strict_types=1);

namespace App\Core\Workflow\Steps;

use App\Core\Workflow\Contracts\TransactionManagerInterface;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Contracts\WorkflowStepInterface;
use Closure;

final readonly class TransactionStep implements WorkflowStepInterface
{
    public function __construct(
        private TransactionManagerInterface $transactionManager,
    ) {}

    public function handle(
        WorkflowContextInterface $context,
        Closure $next,
    ): WorkflowResultInterface {
        return $this->transactionManager->transaction(
            fn (): WorkflowResultInterface => $next($context),
        );
    }
}
