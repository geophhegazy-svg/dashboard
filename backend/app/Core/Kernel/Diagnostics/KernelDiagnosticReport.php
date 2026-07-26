<?php

declare(strict_types=1);

namespace App\Core\Kernel\Diagnostics;

use DateTimeImmutable;

final readonly class KernelDiagnosticReport
{
    public function __construct(
        private int $modules,
        private int $resources,
        private int $dependencies,
        private bool $cacheAvailable,
        private bool $manifestAvailable,
        private ?string $fingerprint,
        private bool $booted,
        private DateTimeImmutable $bootedAt,
        private string $lifecycle,
    ) {}


    public function modules(): int
    {
        return $this->modules;
    }


    public function resources(): int
    {
        return $this->resources;
    }


    public function dependencies(): int
    {
        return $this->dependencies;
    }


    public function cacheAvailable(): bool
    {
        return $this->cacheAvailable;
    }


    public function manifestAvailable(): bool
    {
        return $this->manifestAvailable;
    }


    public function fingerprint(): ?string
    {
        return $this->fingerprint;
    }


    public function booted(): bool
    {
        return $this->booted;
    }


    public function bootedAt(): DateTimeImmutable
    {
        return $this->bootedAt;
    }


    public function lifecycle(): string
    {
        return $this->lifecycle;
    }
}
