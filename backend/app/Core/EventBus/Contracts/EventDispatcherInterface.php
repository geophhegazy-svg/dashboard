<?php

declare(strict_types=1);

namespace App\Core\EventBus\Contracts;

interface EventDispatcherInterface
{
    public function dispatch(
        EventContract $event
    ): void;
}
