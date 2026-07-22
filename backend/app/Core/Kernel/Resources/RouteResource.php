<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use Closure;
use Illuminate\Support\Facades\Route;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

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

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        $registrar->registerRoute(
            $this->routes,
            $this->prefix,
            $this->middleware
        );
    }
