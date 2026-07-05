<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class DependencyGraphKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected DependencyGraphExtractor $extractor = new DependencyGraphExtractor()
    ) {}

    public function filename(): string
    {
        return 'DEPENDENCY_GRAPH.md';
    }

    public function generate(): string
    {
        $graph = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Dependency Graph';
        $markdown[] = '';

        foreach ($graph as $section => $items) {

            $markdown[] = '## ' . ucfirst($section);
            $markdown[] = '';

            foreach ($items as $item) {

                $markdown[] = '- ' . ($item['class'] ?? $item['name']);
            }

            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
