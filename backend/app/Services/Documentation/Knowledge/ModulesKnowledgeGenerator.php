<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class ModulesKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function filename(): string
    {
        return 'MODULES.md';
    }

    public function generate(): string
    {
        $project = $this->scanner->all();

        $markdown = [];

        $markdown[] = '# Modules';
        $markdown[] = '';

        foreach ($project as $module => $classes) {

            $markdown[] = '## ' . ucfirst($module);
            $markdown[] = '';

            $markdown[] = 'Total: ' . count($classes);
            $markdown[] = '';

            foreach ($classes as $class) {

                $markdown[] = '- ' . $class['name'];
            }

            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
