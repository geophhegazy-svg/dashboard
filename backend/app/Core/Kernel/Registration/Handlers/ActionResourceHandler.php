<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration\Handlers;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final readonly class ActionResourceHandler
implements CompiledResourceHandlerInterface
{
    public function supports(
        string $type,
    ): bool {
        return $type === 'actions';
    }


    /**
     * @param array<string,mixed> $resource
     */
    public function register(
        array $resource,
        ModuleRegistrarInterface $registrar,
    ): void {

        foreach (
            $resource['actions'] ?? []
            as $action
        ) {

            $registrar->registerAction(
                $action,
            );
        }
    }
}
