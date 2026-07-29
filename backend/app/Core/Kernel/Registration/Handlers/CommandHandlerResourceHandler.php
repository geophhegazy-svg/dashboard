<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration\Handlers;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Resources\ResourceType;

final readonly class CommandHandlerResourceHandler
implements CompiledResourceHandlerInterface
{
    public function supports(
        string $type,
    ): bool {

        return $type === ResourceType::CommandHandlers->value;
    }


    /**
     * @param array<string,mixed> $resource
     */
    public function register(
        array $resource,
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach (
            $resource['handlers'] ?? []
            as $command => $handler
        ) {

            $registrar->registerCommandHandler(
                $command,
                $handler,
            );
        }
    }
}
