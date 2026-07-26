<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final readonly class CompiledManifestRegistrationService
{
    public function __construct(
        private CompiledResourceRegistrar $registrar,
    ) {}


    public function register(
        CompiledModuleManifest $manifest,
        ModuleRegistrarInterface $moduleRegistrar,
    ): void {

        foreach ($manifest->modules() as $module) {

            foreach ($module->resources() as $resource) {

                $this->registrar->register(
                    $resource,
                    $moduleRegistrar,
                );
            }
        }
    }
}
