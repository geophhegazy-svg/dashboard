<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class ActionResource implements ModuleResourceInterface
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
}
