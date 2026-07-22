<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\RouteResource;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final class RouteResourceTest extends TestCase
{
    public function test_it_registers_module_routes_under_the_api_prefix(): void
    {
        $resource = new RouteResource(
            routes: static function (): void {
                Route::get('/module-route-resource-test', static fn () => [
                    'module' => 'test',
                ]);
            },
        );

        $registrar = $this->app->make(
            ModuleRegistrarInterface::class
        );

        $resource->register($registrar);

        $this->getJson('/api/module-route-resource-test')
            ->assertOk()
            ->assertExactJson([
                'module' => 'test',
            ]);
    }
}
