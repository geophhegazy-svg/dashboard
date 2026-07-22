<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleContract;

final class EgyptNetKernel
{
    private ModuleRegistry $modules;


    public function __construct(
        ModuleRegistrarInterface $registrar
    ) {
        $this->modules = new ModuleRegistry(
            $registrar
        );
    }


    public function register(
        ModuleContract $module
    ): void {

        $this->modules->register(
            $module
        );
    }


    public function modules(): ModuleRegistry
    {
        return $this->modules;
    }


    public function boot(): void
    {
        $this->modules->boot();
    }
}
