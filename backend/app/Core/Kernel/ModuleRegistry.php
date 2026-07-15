<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleContract;

class ModuleRegistry
{
    /**
     * @var ModuleContract[]
     */
    protected array $modules = [];


    public function register(ModuleContract $module): void
    {
        $this->modules[] = $module;

        $module->register();
    }


    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $module->boot();
        }
    }


    public function all(): array
    {
        return $this->modules;
    }
}
