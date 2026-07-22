<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class CommandResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string> $commands
     */
    public function __construct(
        private array $commands,
    ) {}

    /**
     * @return array<class-string>
     */
    public function commands(): array
    {
        return $this->commands;
    }


    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        foreach ($this->commands as $command) {

            $registrar->registerCommand(
                $command
            );
        }
    }
}
