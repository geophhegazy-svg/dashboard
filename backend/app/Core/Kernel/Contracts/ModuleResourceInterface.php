<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface ModuleResourceInterface
{
    public function register(): void;
}
