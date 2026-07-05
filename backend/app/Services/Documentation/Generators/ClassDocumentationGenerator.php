<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

use App\Services\Documentation\Scanner\ProjectScanner;

class ClassDocumentationGenerator
{
    public function __construct(
        protected ProjectScanner $scanner,
    ) {}

    public function generate(): string
    {
        $models = $this->scanner->models();
        $services = $this->scanner->services();

        $markdown = [];

        $markdown[] = "# Classes";
        $markdown[] = "";

        $markdown[] = "## Models";
        $markdown[] = "";

        foreach ($models as $model) {
            $markdown[] = "- {$model['name']}";
        }

        $markdown[] = "";
        $markdown[] = "## Services";
        $markdown[] = "";

        foreach ($services as $service) {
            $markdown[] = "- {$service['name']}";
        }

        return implode(PHP_EOL, $markdown);
    }
}
