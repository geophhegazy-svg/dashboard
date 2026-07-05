<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class RoutesKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected RouteExtractor $extractor = new RouteExtractor()
    ) {}

    public function filename(): string
    {
        return 'ROUTES_FULL.md';
    }

    public function generate(): string
    {
        $routes = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Routes';
        $markdown[] = '';

        foreach ($routes as $route) {

            $markdown[] = '## ' . $route['uri'];
            $markdown[] = '';

            $markdown[] = '- Method: ' . $route['method'];
            $markdown[] = '- Name: ' . $route['name'];
            $markdown[] = '- Action: ' . $route['action'];
            $markdown[] = '- Middleware: ' . $route['middleware'];
            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
