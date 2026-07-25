<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface ModuleCompilableResourceInterface
{
    /**
     * @return array<string, mixed>
     */
    public function compile(): array;
}
