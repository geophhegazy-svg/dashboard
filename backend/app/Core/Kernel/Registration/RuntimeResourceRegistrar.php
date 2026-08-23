<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration;

use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\ModuleManifest;

final readonly class RuntimeResourceRegistrar
{
    public function register(
        ModuleManifest $manifest,
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach ($manifest->resources() as $resource) {

            if ($resource instanceof CompilableModuleResourceInterface) {
                continue;
            }

            $resource->register(
                $registrar,
            );
        }
    }
}
