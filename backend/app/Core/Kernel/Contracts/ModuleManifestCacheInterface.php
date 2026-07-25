<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\Compiler\CompiledModuleManifest;

interface ModuleManifestCacheInterface
{
    public function has(): bool;

    public function load(): ?CompiledModuleManifest;

    public function save(
        CompiledModuleManifest $manifest,
    ): void;

    public function clear(): void;
}
