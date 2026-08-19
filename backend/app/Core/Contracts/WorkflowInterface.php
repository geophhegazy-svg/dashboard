<?php

declare(strict_types=1);

namespace App\Core\Contracts;

use App\Core\Workflow\Contracts\WorkflowContextInterface;

interface WorkflowInterface
{
    public function execute(
        WorkflowContextInterface $context,
    ): mixed;
}
