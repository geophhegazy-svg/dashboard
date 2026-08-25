<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface KernelShutdownManagerInterface
{
    public function shutdown(): void;
}
