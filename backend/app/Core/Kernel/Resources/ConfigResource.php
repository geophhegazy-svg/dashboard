<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class ConfigResource implements ModuleResourceInterface
{
    /**
     * @param array<string,mixed> $configuration
     */
    public function __construct(
        private array $configuration,
    ) {}

    public function register(): void
    {
        config()->set($this->configuration);
    }
}
