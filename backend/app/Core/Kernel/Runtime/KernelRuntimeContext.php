<?php

declare(strict_types=1);

namespace App\Core\Kernel\Runtime;

use App\Core\Kernel\Compiler\CompiledModuleManifest;

final readonly class KernelRuntimeContext
{
    public function __construct(
        private CompiledModuleManifest $manifest,
        private \DateTimeImmutable $bootedAt,
    ) {}


    public function manifest(): CompiledModuleManifest
    {
        return $this->manifest;
    }


    public function bootedAt(): \DateTimeImmutable
    {
        return $this->bootedAt;
    }
}
