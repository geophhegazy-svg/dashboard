<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

use App\Services\Documentation\Scanner\ProjectScanner;

class RepositoryDocumentationGenerator implements GeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner
    ) {}

    public function priority(): int
    {
        return 40;
    }

    public function generate(): string
    {
        $markdown = "# Repositories\n\n";

        if (!method_exists($this->scanner, 'repositories')) {
            return $markdown . "_Scanner not implemented yet._\n";
        }

        foreach ($this->scanner->repositories() as $repository) {
            $markdown .= "- {$repository['name']}\n";
        }

        return $markdown;
    }

    public function filename(): string
    {
        return 'REPOSITORIES.md';
    }
}
