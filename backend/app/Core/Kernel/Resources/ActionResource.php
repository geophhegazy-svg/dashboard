<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\ActionBus\ActionRegistry;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class ActionResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string> $actions
     */
    public function __construct(
        private array $actions,
    ) {}

    public function register(): void
    {
        $registry = app(ActionRegistry::class);

        foreach ($this->actions as $action) {
            $registry->register($action);
        }
    }
}
