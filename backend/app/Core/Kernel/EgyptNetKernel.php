<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\ActionBus\ActionRegistry;
use App\Core\EventBus\EventRegistry;
use App\Core\QueryBus\QueryRegistry;

final readonly class EgyptNetKernel
{
    public function __construct(
        private ModuleRegistry $modules,
        private ActionRegistry $actionRegistry,
        private EventRegistry $eventRegistry,
        private QueryRegistry $queryRegistry,
    ) {}

    public function boot(): void
    {
        foreach ($this->modules->all() as $module) {

            foreach (
                $module->manifest()->resources()
                as $resource
            ) {
                $resource->register();
            }

            $module->boot();
        }
    }

    public function modules(): ModuleRegistry
    {
        return $this->modules;
    }
}
