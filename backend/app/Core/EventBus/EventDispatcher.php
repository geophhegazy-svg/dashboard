<?php

declare(strict_types=1);

namespace App\Core\EventBus;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private readonly EventRegistry $registry,
        private readonly ListenerResolverInterface $resolver,
    ) {}

    public function dispatch(
        EventContract $event
    ): void {
        foreach (
            $this->registry->listenersFor($event)
            as $listener
        ) {

            $this->resolver
                ->resolve($listener)
                ->handle($event);
        }
    }
}
