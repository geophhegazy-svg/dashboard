<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final readonly class SingletonResource implements CompilableModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $bindings
     */
    public function __construct(
        private array $bindings = [],
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {
        foreach ($this->bindings as $abstract => $concrete) {
            $registrar->singleton(
                $abstract,
                $concrete
            );
        }
    }

    /**
     * @return array<string,mixed>
     */
    public function compile(): array
    {
        return [
            'type' => 'singletons',
            'bindings' => $this->bindings,
        ];
    }
}
