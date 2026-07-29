<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;

final readonly class ActionResource implements CompilableModuleResourceInterface
{
    /**
     * @param array<class-string> $actions
     */
    public function __construct(
        private array $actions,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        foreach ($this->actions as $action) {

            $registrar->registerAction(
                $action,
            );
        }
    }

    public function compile(): array
    {
        return [
            'type' => ResourceType::Actions->value,
            'actions' => $this->actions,
        ];
    }
}
