<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration\Handlers;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Resources\ResourceType;

final readonly class SingletonResourceHandler
implements CompiledResourceHandlerInterface
{
    public function supports(
        string $type,
    ): bool {
        return $type === ResourceType::Singletons->value;
    }

    /**
     * @param array<string,mixed> $resource
     */
    public function register(
        array $resource,
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach (
            $resource['bindings'] ?? []
            as $abstract => $concrete
        ) {

            $registrar->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
