<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
final readonly class ConfigResource implements ModuleResourceInterface
{
    /**
     * @param array<string,mixed> $configuration
     */
    public function __construct(
        private array $configuration,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        $registrar->registerConfig(
            $this->configuration
        );
    }
}
