<?php

declare(strict_types=1);

namespace App\Core\EventBus;

use App\Core\EventBus\Contracts\EventContract;

class EventDispatcher
{
    public function __construct(
        private readonly EventRegistry $registry
    ) {}


    public function dispatch(
        EventContract $event
    ): void {

        foreach (
            $this->registry->listenersFor($event)
            as $listener
        ) {

            app($listener)
                ->handle($event);
        }
    }
}
