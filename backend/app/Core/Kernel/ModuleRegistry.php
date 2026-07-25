<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleContract;

final class ModuleRegistry
{
    /**
     * @var array<class-string<ModuleContract>, ModuleContract>
     */
    private array $modules = [];

    public function add(
        ModuleContract $module,
    ): void {

        $this->modules[$module::class] = $module;
    }

    /**
     * @return list<ModuleContract>
     */
    public function all(): array
    {
        return array_values(
            $this->modules,
        );
    }

    public function has(
        string $module,
    ): bool {

        return isset(
            $this->modules[$module],
        );
    }

    public function get(
        string $module,
    ): ?ModuleContract {

        return $this->modules[$module]
            ?? null;
    }

    public function count(): int
    {
        return count(
            $this->modules,
        );
    }

    public function isEmpty(): bool
    {
        return $this->modules === [];
    }
}
