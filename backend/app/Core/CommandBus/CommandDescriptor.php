<?php

declare(strict_types=1);

namespace App\Core\CommandBus;

final readonly class CommandDescriptor
{
    public function __construct(
        public string $command,
        public string $handler,
    ) {}
}
