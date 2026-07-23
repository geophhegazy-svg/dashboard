<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;

final readonly class ModuleManifestCompiler
{
    public function __construct(
        private ModuleDiscoveryInterface $discovery,
    ) {
    }

    public function compile(): array
    {
        $modules = [];

        foreach ($this->discovery->discover() as $module) {
            $modules[] = [
                'class' => $module::class,
                'name' => $module->name(),
                'dependencies' => $module->dependencies(),
            ];
        }

        return $modules;
    }
}
