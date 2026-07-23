<?php

declare(strict_types=1);

namespace App\Core\CommandBus;

use Illuminate\Contracts\Container\Container;
use App\Core\CommandBus\Contracts\CommandInterface;

final readonly class CommandDispatcher
{
    public function __construct(
        private CommandRegistry $registry,
        private Container $container,
    ) {}

    public function dispatch(
        CommandInterface $command,
    ): mixed {

        $descriptor = $this->registry->get(
            $command::class
        );

        if ($descriptor === null) {
            throw new \RuntimeException(
                sprintf(
                    'No command handler registered for [%s].',
                    $command::class,
                )
            );
        }

        $handler = $this->container->make(
            $descriptor->handler
        );

        return $handler->handle(
            $command
        );
    }
}
