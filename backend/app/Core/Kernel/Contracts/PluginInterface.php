<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\ModuleManifest;

interface PluginInterface
{
    public function name(): string;

    public function manifest(): ModuleManifest;

    /**
     * @return array<class-string>
     */
    public function dependencies(): array;
}
