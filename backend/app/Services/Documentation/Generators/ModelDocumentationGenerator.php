<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

use App\Services\Documentation\Scanner\ProjectScanner;

class ModelDocumentationGenerator implements GeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner
    ) {}

    public function generate(): string
    {
        $models = $this->scanner->models();

        $markdown = "# Models\n\n";

        foreach ($models as $model) {
            $markdown .= "- {$model['name']}\n";
        }

        return $markdown;
    }

    public function priority(): int
    {
        return 100;
    }

    public function filename(): string
    {
        return 'MODELS.md';
    }
}
