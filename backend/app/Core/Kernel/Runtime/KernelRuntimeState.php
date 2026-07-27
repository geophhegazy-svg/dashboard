<?php

declare(strict_types=1);

namespace App\Core\Kernel\Runtime;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use DateTimeImmutable;
use RuntimeException;

final class KernelRuntimeState
{
    private ?KernelRuntimeContext $context = null;

    public function set(
        KernelRuntimeContext $context,
    ): void {
        $this->context = $context;
    }

    public function context(): KernelRuntimeContext
    {
        if ($this->context === null) {
            throw new RuntimeException(
                'Kernel runtime context is not initialized.',
            );
        }

        return $this->context;
    }

    public function isBooted(): bool
    {
        return $this->context !== null;
    }

    public function reset(): void
    {
        $this->context = null;
    }

    public function bootedAt(): DateTimeImmutable
    {
        return $this->context()->bootedAt();
    }

    public function manifest(): CompiledModuleManifest
    {
        return $this->context()->manifest();
    }
}
