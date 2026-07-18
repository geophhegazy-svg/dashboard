<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\QueryBus\QueryRegistry;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class QueryResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $queries
     */
    public function __construct(
        private array $queries,
    ) {}

    public function register(): void
    {
        $registry = app(QueryRegistry::class);

        foreach ($this->queries as $query => $handler) {
            $registry->register(
                $query,
                $handler,
            );
        }
    }
}
