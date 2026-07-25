<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\ModuleManifest;

interface ModuleContract
{
    public function name(): string;


    /**
     * @return array<class-string<self>>
     */
    public function dependencies(): array;


    public function manifest(): ModuleManifest;
}
