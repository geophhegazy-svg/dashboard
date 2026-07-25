<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;

final readonly class ServiceResource implements CompilableModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $bindings
     */
    public function __construct(
        private array $bindings,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach ($this->bindings as $abstract => $concrete) {
            $registrar->bind(
                $abstract,
                $concrete,
            );
        }
    }

    /**
     * @return array<string,mixed>
     */
    public function compile(): array
    {
        return [
            'type' => 'services',
            'bindings' => $this->bindings,
        ];
    }
}
