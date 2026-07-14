<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface WorkflowInterface
{
    public function __invoke(mixed $request): mixed;
}
