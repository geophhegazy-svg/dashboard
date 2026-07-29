<?php

declare(strict_types=1);

namespace App\Core\Kernel\Inspector;

use App\Core\Kernel\ModuleRegistry;

/**
 * @internal
 */
final readonly class KernelInspector
{
    public function __construct(
        private ModuleRegistry $registry,
    ) {}

    /**
     * @return list<ModuleInformation>
     */
    public function modules(): array
    {
        $modules = [];

        foreach ($this->registry->all() as $module) {

            $resources = [];

            foreach (
                $module->manifest()->resources()
                as $resource
            ) {
                $resources[] = $resource::class;
            }

            $modules[] = new ModuleInformation(
                class: $module::class,
                name: $module->name(),
                dependencies: $module->dependencies(),
                resources: $resources,
            );
        }

        return $modules;
    }

    public function statistics(): KernelStatistics
    {
        $moduleCount = 0;

        $resourceCount = 0;

        $dependencyCount = 0;

        foreach ($this->registry->all() as $module) {

            ++$moduleCount;

            $resourceCount += count(
                $module->manifest()->resources(),
            );

            $dependencyCount += count(
                $module->dependencies(),
            );
        }

        return new KernelStatistics(
            modules: $moduleCount,
            resources: $resourceCount,
            dependencies: $dependencyCount,
        );
    }

    /**
     * @return array<string,list<string>>
     */
    public function graph(): array
    {
        $graph = [];

        foreach ($this->registry->all() as $module) {

            $dependencies = [];

            foreach ($module->dependencies() as $dependency) {

                $dependencyModule = $this->registry->get(
                    $dependency,
                );

                $dependencies[] = $dependencyModule?->name()
                    ?? class_basename($dependency);
            }

            $graph[$module->name()] = $dependencies;
        }

        return $graph;
    }
}
