<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\ModuleManifest;

interface ModuleContract
{
    public function register(): void;

    public function boot(): void;

    public function name(): string;

    public function manifest(): ModuleManifest;
}
