<?php

declare(strict_types=1);

namespace App\Core\Workflow\Contracts;

use Closure;

interface WorkflowStepInterface
{
    public function handle(
        WorkflowContextInterface $context,
        Closure $next,
    ): WorkflowResultInterface;
}
