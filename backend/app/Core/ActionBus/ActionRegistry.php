<?php

declare(strict_types=1);

namespace App\Core\ActionBus;

final class ActionRegistry
{
    /****
     * @var array<class-string,ActionDescriptor>
     */
    private array $actions = [];

    public function register(
        string $action,
    ): void {

        $this->actions[$action] =
            new ActionDescriptor($action);
    }

    public function get(
        string $action,
    ): ?ActionDescriptor {
        return $this->actions[$action] ?? null;
    }

    public function has(
        string $action,
    ): bool {

        return $this->get($action) !== null;
    }

    /**
     * @return array<int,class-string>
     */
    public function all(): array
    {
        return array_keys($this->actions);
    }
}
