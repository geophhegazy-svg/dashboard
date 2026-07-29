<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use LogicException;

/**
 * @internal
 */
final readonly class CompiledResourceRegistrar
{
    /**
     * @param iterable<CompiledResourceHandlerInterface> $handlers
     */
    public function __construct(
        private iterable $handlers,
    ) {}


    /**
     * @param array<string,mixed> $resource
     */
    public function register(
        array $resource,
        ModuleRegistrarInterface $registrar,
    ): void {

        $type = $resource['type'] ?? null;


        if ($type === null) {

            throw new LogicException(
                'Compiled resource type is missing.',
            );
        }


        foreach ($this->handlers as $handler) {

            if ($handler->supports($type)) {

                $handler->register(
                    $resource,
                    $registrar,
                );

                return;
            }
        }


        throw new LogicException(
            sprintf(
                'No compiled resource handler found for [%s].',
                $type,
            ),
        );
    }
}
