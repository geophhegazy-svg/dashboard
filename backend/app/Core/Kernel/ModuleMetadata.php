<?php

declare(strict_types=1);

namespace App\Core\Kernel;

final readonly class ModuleMetadata
{
    /**
     * @param list<class-string> $requires
     * @param list<class-string> $optional
     * @param list<class-string> $conflicts
     * @param list<class-string> $loadAfter
     * @param list<class-string> $loadBefore
     * @param array<string,mixed> $extra
     */
    public function __construct(
        public string $name,
        public string $version = '1.0.0',
        public string $description = '',
        public string $author = 'EgyptNet',
        public bool $enabled = true,

        public array $requires = [],
        public array $optional = [],
        public array $conflicts = [],
        public array $loadAfter = [],
        public array $loadBefore = [],

        public array $extra = [],
    ) {}
}
