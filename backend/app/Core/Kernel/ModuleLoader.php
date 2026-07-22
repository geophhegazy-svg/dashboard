<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleContract;

final class ModuleLoader
{
    public function __construct(
        private readonly ModuleRegistrarInterface $registrar,
    ) {}

    /**
     * @param array<int, ModuleContract> $modules
     */
    public function load(
        array $modules
    ): void {

        foreach ($modules as $module) {

            $manifest = $module->manifest();

            foreach ($manifest->resources() as $resource) {

                $resource->register(
                    $this->registrar
                );
            }
        }
    }
}
