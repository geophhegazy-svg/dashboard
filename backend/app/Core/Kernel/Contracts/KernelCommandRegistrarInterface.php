<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface KernelCommandRegistrarInterface
{
    public function register(
        string $command,
    ): void;
}
