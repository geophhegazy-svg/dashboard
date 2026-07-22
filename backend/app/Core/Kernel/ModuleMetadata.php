<?php

declare(strict_types=1);

namespace App\Core\Kernel;

final readonly class ModuleMetadata
{
    public function __construct(
        public string $name,
        public string $version = '1.0.0',
        public string $description = '',
        public string $author = 'EgyptNet',
        public bool $enabled = true,
        public array $extra = [],
    ) {}
}
