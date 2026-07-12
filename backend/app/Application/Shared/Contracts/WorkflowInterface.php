<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface WorkflowInterface
{
    /**
     * Execute application workflow.
     */
    public function handle(mixed ...$arguments): mixed;
}
