<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health\Contracts;

use App\Core\Kernel\Health\KernelHealthResult;

interface KernelHealthCheckInterface
{
    public function name(): string;


    public function check(): KernelHealthResult;
}
