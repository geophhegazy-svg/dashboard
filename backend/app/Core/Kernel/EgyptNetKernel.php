<?php

declare(strict_types=1);

namespace App\Core\Kernel;

final readonly class EgyptNetKernel
{
    public function __construct(
        private ModuleRegistry $modules,
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
