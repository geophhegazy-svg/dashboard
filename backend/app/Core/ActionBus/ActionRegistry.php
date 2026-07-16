<?php

declare(strict_types=1);

namespace App\Core\ActionBus;

final class ActionRegistry
{
    /**
     * @var array<class-string,bool>
     */
    private array $actions = [];

    public function register(
        string $action,
    ): void {
        $this->actions[$action] = true;
    }

    public function has(
        string $action,
    ): bool {
        return isset($this->actions[$action]);
    }

    /**
     * @return array<int,class-string>
     */
    public function all(): array
    {
        return array_keys($this->actions);
    }
}
