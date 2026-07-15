<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface ActionInterface
{
    /**
     * Execute action.
     */
    public function execute(
        mixed ...$arguments
    ): mixed;
}
