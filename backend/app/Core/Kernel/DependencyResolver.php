<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Modules\Module;
use RuntimeException;

final class DependencyResolver
{
    /**
     * @param iterable<Module> $modules
     * @return array<Module>
     */
    public function resolve(iterable $modules): array
    {
        $resolved = [];
        $visited = [];

        foreach ($modules as $module) {
            $this->visit(
                $module,
                $modules,
                $resolved,
                $visited
            );
        }

        return array_values($resolved);
    }

    private function visit(
        Module $module,
        iterable $modules,
        array &$resolved,
        array &$visited
    ): void {

        $class = $module::class;

        if (($visited[$class] ?? null) === 'done') {
            return;
        }

        if (($visited[$class] ?? null) === 'visiting') {
            throw new RuntimeException(
                "Circular dependency detected: {$class}"
            );
        }

        $visited[$class] = 'visiting';

        foreach ($module->dependencies() as $dependency) {

            foreach ($modules as $candidate) {

                if ($candidate::class === $dependency) {

                    $this->visit(
                        $candidate,
                        $modules,
                        $resolved,
                        $visited
                    );

                    break;
                }
            }
        }

        $visited[$class] = 'done';

        $resolved[$class] = $module;
    }
}
