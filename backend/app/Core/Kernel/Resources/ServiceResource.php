<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class ServiceResource implements ModuleResourceInterface
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

            $registrar->bind(
                $abstract,
                $concrete
            );
        }
    }
}
