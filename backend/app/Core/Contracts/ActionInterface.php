<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface ActionInterface
{
    public function execute(
        mixed ...$arguments
    ): mixed;
}
