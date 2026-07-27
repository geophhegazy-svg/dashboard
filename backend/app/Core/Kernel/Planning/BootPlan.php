<?php

declare(strict_types=1);

namespace App\Core\Kernel\Planning;

use App\Core\Kernel\Modules\Module;

final readonly class BootPlan
{
    /**
     * @param list<Module> $modules
     */
    public function __construct(
        private array $modules,
    ) {}

    /**
     * @return list<Module>
     */
    public function modules(): array
    {
        return $this->modules;
    }

    public function count(): int
    {
        return count($this->modules);
    }

    public function isEmpty(): bool
    {
        return $this->modules === [];
    }
}
