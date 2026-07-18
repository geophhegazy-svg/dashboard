<?php

declare(strict_types=1);

namespace App\Core\QueryBus;

final readonly class QueryDescriptor
{
    public function __construct(
        public string $query,
        public string $handler,
    ) {}
}
