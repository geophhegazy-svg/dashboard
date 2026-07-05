<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

use App\Services\Documentation\Scanner\ProjectScanner;

class ActionDocumentationGenerator implements GeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner
    ) {}

    public function priority(): int
    {
        return 50;
    }

    public function generate(): string
    {
        $markdown = "# Actions\n\n";

        if (!method_exists($this->scanner, 'actions')) {
            return $markdown . "_Scanner not implemented yet._\n";
        }

        foreach ($this->scanner->actions() as $action) {
            $markdown .= "- {$action['name']}\n";
        }

        return $markdown;
    }

    public function filename(): string
    {
        return 'ACTIONS.md';
    }
}
