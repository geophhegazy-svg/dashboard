<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

class ProjectBibleGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function filename(): string
    {
        return 'PROJECT_BIBLE.md';
    }

    public function generate(): string
    {
        $project = $this->scanner->all();

        $sections = [
            'Models' => $project['models'] ?? [],
            'Services' => $project['services'] ?? [],
            'Controllers' => $project['controllers'] ?? [],
            'Repositories' => $project['repositories'] ?? [],
            'Actions' => $project['actions'] ?? [],
        ];

        $markdown = [
            '# EgyptNet ISP Project Bible',
            '',
            'Generated from the current project structure.',
            '',
        ];

        foreach ($sections as $section => $classes) {
            $markdown[] = '## ' . $section;
            $markdown[] = '';
            $markdown[] = 'Count: ' . count($classes);
            $markdown[] = '';

            foreach ($classes as $class) {
                $markdown[] = '- ' . $class['name'];
            }

            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
