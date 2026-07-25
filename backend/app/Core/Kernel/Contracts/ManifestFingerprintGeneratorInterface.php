<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\Compiler\CompiledModuleManifest;

interface ManifestFingerprintGeneratorInterface
{
    public function generate(
        CompiledModuleManifest $manifest,
    ): string;
}
