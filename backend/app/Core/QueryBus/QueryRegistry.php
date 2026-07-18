<?php

declare(strict_types=1);

namespace App\Core\QueryBus;

final class QueryRegistry
{
    /**
     * @var array<class-string,QueryDescriptor>
     */
    private array $queries = [];

    public function register(
        string $query,
        string $handler,
    ): void {

        $this->queries[$query] =
            new QueryDescriptor(
                $query,
                $handler,
            );
    }

    public function has(
        string $query,
    ): bool {

        return isset(
            $this->queries[$query]
        );
    }

    public function get(
        string $query,
    ): ?QueryDescriptor {

        return $this->queries[$query]
            ?? null;
    }

    /**
     * @return array<class-string>
     */
    public function all(): array
    {
        return array_keys(
            $this->queries
        );
    }
}
