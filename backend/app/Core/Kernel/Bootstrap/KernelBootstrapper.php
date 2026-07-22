<?php

declare(strict_types=1);

namespace App\Core\Kernel\Bootstrap;

use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\DependencyResolver;

final readonly class KernelBootstrapper implements KernelBootstrapperInterface
{
    public function __construct(
        private ModuleDiscoveryInterface $discovery,
        private ModuleRegistrarInterface $registrar,
        private DependencyResolver $resolver,
    ) {}

    public function boot(): void
    {
        event(
            new \App\Core\Kernel\Events\KernelBooting()
        );

        $modules = $this->resolver->resolve(
            $this->discovery->discover()
        );

        foreach ($modules as $module) {

            event(
                new \App\Core\Kernel\Events\ModuleBooting($module)
            );

            foreach ($module->manifest()->resources() as $resource) {

                $resource->register(
                    $this->registrar
                );
            }

            event(
                new \App\Core\Kernel\Events\ModuleBooted($module)
            );
        }

        event(
            new \App\Core\Kernel\Events\KernelBooted()
        );
    }
}
