<?php

declare(strict_types=1);

namespace Tests\Fakes\Core;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventDispatcherInterface;

final class FakeEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var list<EventContract>
     */
    private array $events = [];


    public function dispatch(
        EventContract $event
    ): void {

        $this->events[] = $event;
    }


    public function has(
        string $event
    ): bool {

        foreach ($this->events as $dispatched) {

            if ($dispatched instanceof $event) {
                return true;
            }
        }

        return false;
    }


    /**
     * @return list<EventContract>
     */
    public function all(): array
    {
        return $this->events;
    }
}
