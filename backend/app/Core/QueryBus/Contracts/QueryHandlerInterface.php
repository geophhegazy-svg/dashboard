<?php

declare(strict_types=1);

namespace App\Core\QueryBus\Contracts;

interface QueryHandlerInterface
{
    public function handle(
        QueryInterface $query,
    ): mixed;
}
