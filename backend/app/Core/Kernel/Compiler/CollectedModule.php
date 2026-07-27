<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

final readonly class CollectedModule
{
    /**
     * @param list<class-string> $dependencies
     * @param list<array<string,mixed>> $resources
     */
    public function __construct(
        public string $class,
        public string $name,
        public array $dependencies,
        public array $resources,
    ) {}
}
