<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

use Illuminate\Support\Facades\Route;

class ApiDocumentationGenerator implements GeneratorInterface
{
    public function priority(): int
    {
        return 50;
    }

    public function filename(): string
    {
        return 'API.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# API Documentation';
        $markdown[] = '';

        $routes = collect(Route::getRoutes())
            ->sortBy(fn($route) => $route->uri());

        foreach ($routes as $route) {

            $methods = implode(
                '|',
                array_diff(
                    $route->methods(),
                    ['HEAD']
                )
            );

            $markdown[] = '## ' . $methods . ' /' . ltrim($route->uri(), '/');
            $markdown[] = '';

            $markdown[] = '- **Action:** ' . ($route->getActionName() ?: 'Closure');
            $markdown[] = '- **Name:** ' . ($route->getName() ?: '-');
            $markdown[] = '- **Middleware:** ' . implode(', ', $route->gatherMiddleware());

            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
