<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Generators;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

class ControllerDocumentationGenerator implements GeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner
    ) {}

    public function priority(): int
    {
        return 30;
    }

    public function generate(): string
    {
        $markdown = "# Controllers\n\n";

        if (!method_exists($this->scanner, 'controllers')) {
            return $markdown . "_Scanner not implemented yet._\n";
        }

        foreach ($this->scanner->controllers() as $controller) {
            $markdown .= "- {$controller['name']}\n";
        }

        return $markdown;
    }
    public function filename(): string
    {
        return 'CONTROLLERS.md';
    }
}
