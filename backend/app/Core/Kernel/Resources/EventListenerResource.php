<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Contracts\ModuleResourceInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final readonly class EventListenerResource
implements ModuleResourceInterface
{
    public function __construct(
        private string $event,
        private string $listener,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        $registrar->registerListener(
            $this->event,
            $this->listener
        );
    }
}
