<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

final readonly class CollectedManifest
{
    /**
     * @param list<CollectedModule> $modules
     */
    public function __construct(
        public array $modules,
    ) {}
}
