<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Contract;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;
use Tests\TestCase;

final class ApiRouteSurfaceContractTest extends TestCase
{
    public function test_only_login_endpoints_are_public(): void
    {
        $routes = collect(RouteFacade::getRoutes()->getRoutes())
            ->filter(
                static fn (Route $route): bool =>
                    str_starts_with($route->uri(), 'api/')
            );

        $this->assertCount(130, $routes);

        $public = $routes
            ->filter(
                static fn (Route $route): bool =>
                    ! collect($route->middleware())
                        ->contains(
                            static fn (string $middleware): bool =>
                                str_contains(
                                    $middleware,
                                    'auth:sanctum'
                                )
                        )
            )
            ->map(
                static fn (Route $route): string =>
                    implode('|', $route->methods())
                    . ' '
                    . $route->uri()
            )
            ->values()
            ->all();

        sort($public);

        $this->assertSame(
            [
                'POST api/customer/login',
                'POST api/login',
            ],
            $public
        );
    }

    public function test_all_non_login_api_routes_are_sanctum_protected(): void
    {
        $routes = collect(RouteFacade::getRoutes()->getRoutes())
            ->filter(
                static fn (Route $route): bool =>
                    str_starts_with($route->uri(), 'api/')
            );

        $publicUris = [
            'POST api/customer/login',
            'POST api/login',
        ];

        $unprotected = $routes
            ->filter(
                static function (Route $route) use ($publicUris): bool {
                    $signature = implode('|', $route->methods())
                        . ' '
                        . $route->uri();

                    if (in_array($signature, $publicUris, true)) {
                        return false;
                    }

                    return ! collect($route->middleware())
                        ->contains(
                            static fn (string $middleware): bool =>
                                str_contains(
                                    $middleware,
                                    'auth:sanctum'
                                )
                        );
                }
            )
            ->map(
                static fn (Route $route): string =>
                    implode('|', $route->methods())
                    . ' '
                    . $route->uri()
            )
            ->values()
            ->all();

        $this->assertSame([], $unprotected);
    }

    public function test_api_routes_have_no_duplicate_method_uri_pairs(): void
    {
        $routes = collect(RouteFacade::getRoutes()->getRoutes())
            ->filter(
                static fn (Route $route): bool =>
                    str_starts_with($route->uri(), 'api/')
            );

        $pairs = $routes
            ->map(
                static fn (Route $route): string =>
                    implode('|', $route->methods())
                    . ' '
                    . $route->uri()
            );

        $duplicates = $pairs
            ->duplicates()
            ->values()
            ->all();

        $this->assertSame([], $duplicates);
    }
}
