<?php

declare(strict_types=1);

namespace App\Core\Kernel\Modules;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\ModuleManifest;

abstract class Module implements ModuleContract
{
    abstract public function name(): string;

    public function register(): void {}

    public function boot(): void {}

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make();
    }
}
