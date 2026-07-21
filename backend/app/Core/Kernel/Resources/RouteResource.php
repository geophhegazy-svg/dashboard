<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use Closure;
use Illuminate\Support\Facades\Route;

final readonly class RouteResource implements ModuleResourceInterface
{
    /**
     * @param Closure|non-empty-string $routes
     * @param list<string> $middleware
     */
    public function __construct(
        private Closure|string $routes,
        private string $prefix = 'api',
        private array $middleware = ['api'],
    ) {}

    public function register(): void
    {
        Route::middleware($this->middleware)
            ->prefix($this->prefix)
            ->group($this->routes);
    }
}
