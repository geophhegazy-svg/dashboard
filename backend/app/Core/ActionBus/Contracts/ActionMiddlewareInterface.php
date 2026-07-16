<?php

declare(strict_types=1);

namespace App\Core\ActionBus\Contracts;

interface ActionMiddlewareInterface
{
    public function handle(
        string $action,
        array $arguments,
        callable $next,
    ): mixed;
}
