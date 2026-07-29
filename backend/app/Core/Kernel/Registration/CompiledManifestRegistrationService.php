<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration;

use App\Core\Contracts\ContainerInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Events\ModuleBooted;
use App\Core\Kernel\Events\ModuleBooting;

final readonly class CompiledManifestRegistrationService
{
    public function __construct(
        private CompiledResourceRegistrar $registrar,
        private EventDispatcherInterface $events,
        private ContainerInterface $container,
    ) {}

    public function register(
        CompiledModuleManifest $manifest,
        ModuleRegistrarInterface $moduleRegistrar,
    ): void {

        foreach ($manifest->modules() as $module) {

            $moduleInstance = $this->resolveModule(
                $module->class(),
            );

            $this->events->dispatch(
                new ModuleBooting(
                    $moduleInstance,
                ),
            );

            foreach ($module->resources() as $resource) {

                $this->registrar->register(
                    $resource,
                    $moduleRegistrar,
                );
            }

            $this->events->dispatch(
                new ModuleBooted(
                    $moduleInstance,
                ),
            );
        }
    }

    private function resolveModule(
        string $class,
    ): ModuleContract {

        /** @var ModuleContract */
        return $this->container->make($class);
    }
}
