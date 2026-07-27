<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;
use App\Core\Kernel\Modules\Module;

final class ManifestCollector
{
    /**
     * @param iterable<Module> $modules
     */
    public function collect(
        iterable $modules,
    ): CollectedManifest {

        $collected = [];

        foreach ($modules as $module) {

            $resources = [];

            foreach (
                $module
                    ->manifest()
                    ->resources()
                as $resource
            ) {

                if (! $resource instanceof CompilableModuleResourceInterface) {
                    continue;
                }

                $resources[] = $resource->compile();
            }

            $collected[] = new CollectedModule(
                class: $module::class,
                name: $module->name(),
                dependencies: $module->dependencies(),
                resources: $resources,
            );
        }

        return new CollectedManifest(
            $collected,
        );
    }
}
