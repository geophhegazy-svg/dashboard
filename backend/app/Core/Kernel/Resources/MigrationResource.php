<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class MigrationResource implements ModuleResourceInterface
{
    /**
     * @param list<string> $paths
     */
    public function __construct(
        private array $paths,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        $registrar->registerMigration(
            $this->paths
        );
    }
}
