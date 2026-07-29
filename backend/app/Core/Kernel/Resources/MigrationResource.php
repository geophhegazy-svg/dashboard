<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;

final readonly class MigrationResource implements CompilableModuleResourceInterface
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

    public function compile(): array
    {
        return [
            'type' => ResourceType::Migrations->value,
            'paths' => $this->paths,
        ];
    }
}
