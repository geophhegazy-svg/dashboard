<?php

declare(strict_types=1);

namespace App\Core\Kernel\Plugins;

use App\Core\Kernel\Contracts\PluginInterface;
use App\Core\Kernel\ModuleManifest;

abstract class Plugin implements PluginInterface
{
    public function dependencies(): array
    {
        return [];
    }

    abstract public function name(): string;

    abstract public function manifest(): ModuleManifest;
}
