<?php

declare(strict_types=1);

namespace App\Core\Kernel\Discovery;

use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Discovery\Contracts\ModuleSourceInterface;
use App\Core\Kernel\Modules\Module;
use RuntimeException;

final readonly class ModuleDiscovery implements ModuleDiscoveryInterface
{
    public function __construct(
        private ModuleSourceInterface $source,
    ) {}


    public function discover(): iterable
    {
        return $this->sortModules(
            iterator_to_array(
                $this->source->modules()
            )
        );
    }


    /**
     * @param array<int, Module> $modules
     * @return array<int, Module>
     */
    private function sortModules(
        array $modules,
    ): array {

        $map = [];

        foreach ($modules as $module) {
            $map[$module::class] = $module;
        }


        $sorted = [];
        $visited = [];
        $visiting = [];


        foreach ($modules as $module) {

            $this->visit(
                $module,
                $map,
                $visited,
                $visiting,
                $sorted
            );
        }


        return $sorted;
    }


    /**
     * @param array<class-string<Module>, Module> $map
     * @param array<class-string<Module>, bool> $visited
     * @param array<class-string<Module>, bool> $visiting
     * @param array<int, Module> $sorted
     */
    private function visit(
        Module $module,
        array $map,
        array &$visited,
        array &$visiting,
        array &$sorted,
    ): void {

        $class = $module::class;


        if (isset($visited[$class])) {
            return;
        }


        if (isset($visiting[$class])) {

            throw new RuntimeException(
                "Circular module dependency detected: {$class}"
            );
        }


        $visiting[$class] = true;


        foreach ($module->dependencies() as $dependency) {

            if (! isset($map[$dependency])) {

                throw new RuntimeException(
                    "Missing module dependency: {$dependency}"
                );
            }


            $this->visit(
                $map[$dependency],
                $map,
                $visited,
                $visiting,
                $sorted
            );
        }


        unset($visiting[$class]);


        $visited[$class] = true;


        $sorted[] = $module;
    }
}
