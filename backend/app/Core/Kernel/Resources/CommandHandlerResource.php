<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class CommandHandlerResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $commands
     */
    public function __construct(
        private array $commands,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach ($this->commands as $command => $handler) {
            $registrar->registerCommandHandler(
                $command,
                $handler,
            );
        }
    }
}
