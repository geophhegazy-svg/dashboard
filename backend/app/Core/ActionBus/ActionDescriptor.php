<?php

declare(strict_types=1);

namespace App\Core\ActionBus;

final readonly class ActionDescriptor
{
    public function __construct(
        public string $action,
    ) {}
}
