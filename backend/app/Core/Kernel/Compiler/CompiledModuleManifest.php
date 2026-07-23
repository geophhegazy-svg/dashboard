<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

final readonly class CompiledModuleManifest
{
    public function __construct(
        public array $modules,
    ) {}
}
