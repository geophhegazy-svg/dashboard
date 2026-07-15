<?php

declare(strict_types=1);

namespace App\Core\Kernel\Modules;

use App\Core\Kernel\Contracts\ModuleContract;

abstract class Module implements ModuleContract
{
    public function register(): void {}

    public function boot(): void {}
}
