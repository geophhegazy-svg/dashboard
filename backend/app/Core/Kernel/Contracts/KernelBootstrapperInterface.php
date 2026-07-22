<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface KernelBootstrapperInterface
{
    public function boot(): void;
}
