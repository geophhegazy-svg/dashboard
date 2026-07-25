<?php

declare(strict_types=1);

namespace App\Core\Kernel\Inspector;

final readonly class KernelStatistics
{
    public function __construct(
        private int $modules,
        private int $resources,
        private int $dependencies,
    ) {}

    public function modules(): int
    {
        return $this->modules;
    }

    public function resources(): int
    {
        return $this->resources;
    }

    public function dependencies(): int
    {
        return $this->dependencies;
    }
}
