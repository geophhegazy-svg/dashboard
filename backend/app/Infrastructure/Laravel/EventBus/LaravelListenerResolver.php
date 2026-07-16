<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\EventBus;

use LogicException;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Core\EventBus\Contracts\ListenerResolverInterface;

final class LaravelListenerResolver implements ListenerResolverInterface
{
    public function resolve(
        string $listener
    ): EventListenerInterface {

        $instance = app($listener);

        if (! $instance instanceof EventListenerInterface) {
            throw new LogicException(
                sprintf(
                    '%s must implement %s.',
                    get_debug_type($instance),
                    EventListenerInterface::class,
                )
            );
        }

        return $instance;
    }
}
