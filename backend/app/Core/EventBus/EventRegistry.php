<?php

declare(strict_types=1);

namespace App\Core\EventBus;

use App\Core\EventBus\Contracts\EventContract;

class EventRegistry
{
    protected array $listeners = [];


    public function register(
        string $event,
        string $listener
    ): void {

        $this->listeners[$event][] = $listener;
    }


    public function listenersFor(
        EventContract $event
    ): array {

        return $this->listeners[$event::class] ?? [];
    }
}
