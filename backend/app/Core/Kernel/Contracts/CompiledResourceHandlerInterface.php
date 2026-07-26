<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface CompiledResourceHandlerInterface
{
    public function supports(
        string $type,
    ): bool;


    /**
     * @param array<string,mixed> $resource
     */
    public function register(
        array $resource,
        ModuleRegistrarInterface $registrar,
    ): void;
}
