<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class EventListenerResource
implements ModuleResourceInterface
{
    public function __construct(
        private string $event,
        private string $listener,
    ) {}

    public function register(): void
    {
        app(EventRegistry::class)
            ->register(
                $this->event,
                $this->listener,
            );
    }
}
