<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleContract;

final class ModuleRegistry
{
    /**
     * @var list<ModuleContract>
     */
    private array $modules = [];


    public function add(
        ModuleContract $module,
    ): void {

        $this->modules[] = $module;
    }


    /**
     * @return list<ModuleContract>
     */
    public function all(): array
    {
        return $this->modules;
    }


    public function has(
        string $module,
    ): bool {

        foreach ($this->modules as $item) {

            if ($item::class === $module) {
                return true;
            }
        }

        return false;
    }


    public function get(
        string $module,
    ): ?ModuleContract {

        foreach ($this->modules as $item) {

            if ($item::class === $module) {
                return $item;
            }
        }

        return null;
    }


    public function count(): int
    {
        return count($this->modules);
    }


    public function isEmpty(): bool
    {
        return $this->modules === [];
    }


    public function reset(): void
    {
        $this->modules = [];
    }
}
