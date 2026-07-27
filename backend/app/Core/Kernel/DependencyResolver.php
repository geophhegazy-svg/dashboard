<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Modules\Module;
use RuntimeException;

final class DependencyResolver
{
    /**
     * @param iterable<Module> $modules
     * @return list<Module>
     */
    public function resolve(iterable $modules): array
    {
        $modules = iterator_to_array($modules, false);

        $map = [];

        foreach ($modules as $module) {
            $map[$module::class] = $module;
        }

        $resolved = [];
        $visited = [];

        foreach ($modules as $module) {
            $this->visit(
                $module,
                $map,
                $resolved,
                $visited,
            );
        }

        return array_values($resolved);
    }

    /**
     * @param array<class-string,Module> $modules
     * @param array<class-string,Module> $resolved
     * @param array<class-string,string> $visited
     */
    private function visit(
        Module $module,
        array $modules,
        array &$resolved,
        array &$visited,
    ): void {

        $class = $module::class;

        if (($visited[$class] ?? null) === 'done') {
            return;
        }

        if (($visited[$class] ?? null) === 'visiting') {

            throw new RuntimeException(
                sprintf(
                    'Circular dependency detected for [%s].',
                    $class,
                ),
            );
        }

        $visited[$class] = 'visiting';

        foreach ($module->dependencies() as $dependency) {

            if (! isset($modules[$dependency])) {

                throw new RuntimeException(
                    sprintf(
                        'Missing dependency [%s] required by [%s].',
                        $dependency,
                        $class,
                    ),
                );
            }

            $this->visit(
                $modules[$dependency],
                $modules,
                $resolved,
                $visited,
            );
        }

        $visited[$class] = 'done';

        $resolved[$class] = $module;
    }
}
