<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

use App\Services\Documentation\Scanner\ProjectScanner;

class ServiceDocumentationGenerator implements GeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner
    ) {}

    public function generate(): string
    {
        $services = $this->scanner->services();

        $markdown = "# Services\n\n";

        foreach ($services as $service) {
            $markdown .= "- {$service['name']}\n";
        }

        return $markdown;
    }

    public function priority(): int
    {
        return 200;
    }
    public function filename(): string
    {
        return 'SERVICES.md';
    }
}
