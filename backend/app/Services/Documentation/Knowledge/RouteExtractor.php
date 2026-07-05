<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use Illuminate\Support\Facades\Route;

class RouteExtractor
{
    public function extract(): array
    {
        return collect(Route::getRoutes())
            ->map(function ($route): array {

                return [

                    'method' => implode('|', $route->methods()),

                    'uri' => $route->uri(),

                    'name' => $route->getName() ?? '-',

                    'action' => $route->getActionName(),

                    'middleware' => implode(', ', $route->gatherMiddleware()),

                ];
            })
            ->values()
            ->toArray();
    }
}
