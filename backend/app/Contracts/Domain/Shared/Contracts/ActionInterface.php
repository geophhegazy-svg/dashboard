<?php

declare(strict_types=1);

namespace App\Contracts\Domain\Shared\Contracts;

interface ActionInterface
{
    /**
     * Execute the action.
     *
     * @param mixed ...$arguments
     * @return mixed
     */
    public function execute(
        mixed ...$arguments
    ): mixed;
}
