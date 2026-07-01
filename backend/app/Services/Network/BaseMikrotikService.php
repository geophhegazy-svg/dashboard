<?php

declare(strict_types=1);

namespace App\Services\Network;

use RouterOS\Query;

abstract class BaseMikrotikService
{
    public function __construct(
        protected readonly MikrotikConnection $connection
    ) {}

    protected function execute(Query $query): array
    {
        return $this->connection->execute($query);
    }
}
