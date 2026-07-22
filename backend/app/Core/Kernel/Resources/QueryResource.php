<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class QueryResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $queries
     */
    public function __construct(
        private array $queries,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        foreach ($this->queries as $query => $handler) {

            $registrar->registerQuery(
                $query,
                $handler,
            );
        }
    }
}
