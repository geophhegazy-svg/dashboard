<?php

declare(strict_types=1);

namespace App\Core\CommandBus;

final class CommandRegistry
{
    /**
     * @var array<class-string,CommandDescriptor>
     */
    private array $commands = [];

    public function register(
        string $command,
        string $handler,
    ): void {

        $this->commands[$command] =
            new CommandDescriptor(
                $command,
                $handler,
            );
    }

    public function get(
        string $command,
    ): ?CommandDescriptor {

        return $this->commands[$command]
            ?? null;
    }

    public function has(
        string $command,
    ): bool {

        return isset(
            $this->commands[$command]
        );
    }
}
