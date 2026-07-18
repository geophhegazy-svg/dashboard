<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class ListenerResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,array<class-string>> $listeners
     */
    public function __construct(
        private array $listeners,
    ) {}

    public function register(): void
    {
        $registry = app(EventRegistry::class);

        foreach ($this->listeners as $event => $listeners) {

            foreach ($listeners as $listener) {

                $registry->register(
                    $event,
                    $listener,
                );
            }
        }
    }
}
