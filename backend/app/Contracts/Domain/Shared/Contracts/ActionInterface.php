<?php

declare(strict_types=1);

namespace App\Domain\Shared\Contracts;

interface ActionInterface
{
    /**
     * Execute domain action.
     */
    public function execute(mixed ...$arguments): mixed;
}
