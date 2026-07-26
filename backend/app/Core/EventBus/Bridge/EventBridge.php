<?php

declare(strict_types=1);

namespace App\Core\EventBus\Bridge;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventDispatcherInterface;

final readonly class EventBridge
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
    ) {}


    public function handle(
        object $event,
    ): void {

        if (! $event instanceof EventContract) {
            return;
        }


        $this->dispatcher->dispatch(
            $event,
        );
    }
}
