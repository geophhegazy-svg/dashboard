<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use Illuminate\Support\Facades\Route;

class RoutesKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function filename(): string
    {
        return 'ROUTES_FULL.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# Routes';
        $markdown[] = '';

        foreach (Route::getRoutes() as $route) {

            $markdown[] = '---';
            $markdown[] = '';

            $markdown[] = '## ' . $route->uri();
            $markdown[] = '';

            $markdown[] = '**Methods**';
            $markdown[] = '';

            foreach ($route->methods() as $method) {
                $markdown[] = '- ' . $method;
            }

            $markdown[] = '';

            $markdown[] = '**Name**';
            $markdown[] = '';
            $markdown[] = $route->getName() ?: '-';
            $markdown[] = '';

            $markdown[] = '**Action**';
            $markdown[] = '';
            $markdown[] = $route->getActionName();
            $markdown[] = '';

            $markdown[] = '**Middleware**';
            $markdown[] = '';

            foreach ($route->gatherMiddleware() as $middleware) {
                $markdown[] = '- ' . $middleware;
            }

            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
