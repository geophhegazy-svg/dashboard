<?php

declare(strict_types=1);

namespace App\Core\EventBus\Contracts;

interface ListenerResolverInterface
{
    public function resolve(
        string $listener
    ): EventListenerInterface;
}
