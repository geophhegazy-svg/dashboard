<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\ModuleRegistry;

interface ModuleLoaderInterface
{
    public function load(): ModuleRegistry;
}
