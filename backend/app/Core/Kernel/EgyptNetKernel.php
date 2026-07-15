<?php

declare(strict_types=1);

namespace App\Core\Kernel;

class EgyptNetKernel
{

    public function __construct(
        private readonly ModuleRegistry $modules
    ) {}


    public function boot(): void
    {
        $this->modules->boot();
    }


    public function modules(): ModuleRegistry
    {
        return $this->modules;
    }
}
