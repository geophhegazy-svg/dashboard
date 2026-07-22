<?php

declare(strict_types=1);

namespace App\Core\Kernel\Discovery;

use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Modules\Module;
use Illuminate\Support\Facades\File;
use RuntimeException;

final class ModuleDiscovery implements ModuleDiscoveryInterface
{
    public function discover(): iterable
    {
        return $this->sortModules(
            $this->discoverModules()
        );
    }

    /**
     * @return array<int, Module>
     */
    private function discoverModules(): array
    {
        $modules = [];

        $modulesPath = app_path('Modules');

        if (! File::exists($modulesPath)) {
            return [];
        }

        foreach (File::directories($modulesPath) as $directory) {

            $module = basename($directory);

            $class = sprintf(
                'App\\Modules\\%s\\Kernel\\%sModule',
                $module,
                $module
            );

            if (! class_exists($class)) {
                continue;
            }

            $instance = app($class);

            if ($instance instanceof Module) {
                $modules[] = $instance;
            }
        }

        return $modules;
    }

    /**
     * @param array<int, Module> $modules
     * @return array<int, Module>
     */
    private function sortModules(array $modules): array
    {
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
