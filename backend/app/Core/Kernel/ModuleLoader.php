<?php

declare(strict_types=1);

namespace App\Core\Kernel;

final class ModuleLoader
{
    /**
     * @param array<int, Module> $modules
     */
    public function load(array $modules): void
    {
        foreach ($modules as $module) {

            $manifest = $module->manifest();

            foreach ($manifest->resources() as $resource) {
                $resource->register();
            }
        }
    }
}
