<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use Illuminate\Database\Migrations\Migrator;

final readonly class MigrationResource implements ModuleResourceInterface
{
    /**
     * @param list<non-empty-string> $paths
     */
    public function __construct(
        private array $paths,
    ) {}

    public function register(): void
    {
        $migrator = app(Migrator::class);

        foreach ($this->paths as $path) {
            $migrator->path($path);
        }
    }
}
