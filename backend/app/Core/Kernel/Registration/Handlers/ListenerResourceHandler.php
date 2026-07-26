<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration\Handlers;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final readonly class ListenerResourceHandler
implements CompiledResourceHandlerInterface
{
    public function supports(
        string $type,
    ): bool {

        return $type === 'listeners';
    }


    /**
     * @param array<string,mixed> $resource
     */
    public function register(
        array $resource,
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach (
            $resource['listeners'] ?? []
            as $event => $listeners
        ) {

            foreach ($listeners as $listener) {

                $registrar->registerListener(
                    $event,
                    $listener,
                );
            }
        }
    }
}
