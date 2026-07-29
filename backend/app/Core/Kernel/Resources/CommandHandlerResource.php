<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;

final readonly class CommandHandlerResource implements CompilableModuleResourceInterface
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

    public function compile(): array
    {
        return [
            'type' => ResourceType::CommandHandlers->value,
            'handlers' => $this->commands,
        ];
    }
}
