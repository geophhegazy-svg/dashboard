<?php

declare(strict_types=1);

namespace App\Core\Kernel\Modules;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\ModuleManifest;

abstract class Module implements ModuleContract
{
    /**
     * اسم الـ Module.
     */
    abstract public function name(): string;


    /**
     * Dependencies بين الـ Modules.
     *
     * @return array<class-string<Module>>
     */
    public function dependencies(): array
    {
        return [];
    }


    /**
     * المصدر الوحيد لتعريف موارد الـ Module.
     */
    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make();
    }
}
