<?php

declare(strict_types=1);

namespace App\Contracts\Network;

use RouterOS\Query;

interface RouterQueryInterface
{
    /**
     * Execute a query and return all results.
     *
     * @return array<int, array<string, mixed>>
     */
    public function execute(Query|string $query): array;

    /**
     * Execute a query and return the first row.
     *
     * @return array<string, mixed>|null
     */
    public function executeOne(Query|string $query): ?array;

    /**
     * Execute a write operation.
     */
    public function write(Query|string $query): bool;

    /**
     * Execute safely without throwing exceptions.
     *
     * @return array<int, array<string, mixed>>
     */
    public function safeExecute(Query|string $query): array;

    /**
     * Execute a write operation safely.
     */
    public function safeWrite(Query|string $query): bool;
}
