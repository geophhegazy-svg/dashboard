<?php

declare(strict_types=1);

namespace App\Core\Kernel\Modules;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\ModuleManifest;

abstract class Module implements ModuleContract
{
    abstract public function name(): string;

    /**
     * @return array<class-string<Module>>
     */
    public function dependencies(): array
    {
        return [];
    }

    /**
     * @deprecated استخدم ModuleManifest بدلاً منه.
     */
    public function register(): void {}

    /**
     * @deprecated استخدم ModuleManifest بدلاً منه.
     */
    public function boot(): void {}

    /**
     * المصدر الوحيد لتعريف مكونات الـ Module.
     */
    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make();
    }
}
