<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Events\ModuleBooted;
use App\Core\Kernel\Events\ModuleBooting;
use App\Core\Kernel\ModuleRegistry;

final readonly class ModuleRegistrationService
{
    public function __construct(
        private ModuleRegistrarInterface $registrar,
    ) {}

    public function register(
        ModuleRegistry $registry,
    ): void {

        foreach ($registry->all() as $module) {

            $this->registerModule($module);
        }
    }

    private function registerModule(
        ModuleContract $module,
    ): void {

        event(
            new ModuleBooting($module),
        );

        foreach (
            $module->manifest()->resources()
            as $resource
        ) {

            $resource->register(
                $this->registrar,
            );
        }

        event(
            new ModuleBooted($module),
        );
    }
}
