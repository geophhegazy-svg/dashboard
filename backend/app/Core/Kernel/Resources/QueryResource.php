<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;

final readonly class QueryResource implements CompilableModuleResourceInterface
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

    public function compile(): array
    {
        return [
            'type' => ResourceType::Queries->value,
            'queries' => $this->queries,
        ];
    }
}
