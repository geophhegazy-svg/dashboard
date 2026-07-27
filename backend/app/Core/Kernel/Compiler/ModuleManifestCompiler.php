<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

final class ModuleManifestCompiler
{
    public function compile(
        CollectedManifest $manifest,
    ): CompiledModuleManifest {

        $compiledModules = [];

        foreach ($manifest->modules as $module) {

            $compiledModules[] = new CompiledModule(
                class: $module->class,
                name: $module->name,
                dependencies: $module->dependencies,
                resources: $module->resources,
            );
        }

        return new CompiledModuleManifest(
            $compiledModules,
        );
    }
}

