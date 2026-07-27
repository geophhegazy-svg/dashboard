<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Generators;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

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
