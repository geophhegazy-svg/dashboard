<?php

declare(strict_types=1);

namespace App\Core\Kernel\Loader;

use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\ModuleRegistry;

final readonly class ModuleLoader implements ModuleLoaderInterface
{
    public function __construct(
        private ModuleDiscoveryInterface $discovery,
        private ModuleRegistry $registry,
    ) {}

    public function load(): ModuleRegistry
    {
        foreach ($this->discovery->discover() as $module) {

            $this->registry->add(
                $module,
            );
        }

        return $this->registry;
    }
}
