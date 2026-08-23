<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Compiler;

use App\Core\Kernel\Compiler\ManifestCollector;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Modules\Module;
use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Resources\RouteResource;
use App\Core\Kernel\Resources\ListenerResource;
use App\Core\EventBus\Contracts\EventContract;
use Closure;
use PHPUnit\Framework\TestCase;

final class ManifestCollectorTest extends TestCase
{
    public function test_it_compiles_listener_resources(): void
    {
        $module = new class extends Module {
            public function name(): string
            {
                return 'listener-collector-test';
            }

            public function manifest(): ModuleManifest
            {
                return ModuleManifest::make()
                    ->listeners([
                        ManifestCollectorListenerEvent::class => [
                            ManifestCollectorListener::class,
                        ],
                    ]);
            }
        };

        $manifest = (new ManifestCollector())->collect([$module]);

        self::assertSame(
            [
                [
                    'type' => 'listeners',
                    'listeners' => [
                        ManifestCollectorListenerEvent::class => [
                            ManifestCollectorListener::class,
                        ],
                    ],
                ],
            ],
            $manifest->modules[0]->resources,
        );
    }

    public function test_it_collects_only_compilable_resources(): void
    {
        $compiledResource = new class implements CompilableModuleResourceInterface {
            public function register(
                ModuleRegistrarInterface $registrar,
            ): void {
            }

            public function compile(): array
            {
                return [
                    'type' => 'test',
                    'value' => 'compiled',
                ];
            }
        };

        $runtimeOnlyResource = new RouteResource(
            static function (): void {
            },
        );

        $module = new class(
            $compiledResource,
            $runtimeOnlyResource,
        ) extends Module {
            public function __construct(
                private readonly CompilableModuleResourceInterface $compiled,
                private readonly RouteResource $runtime,
            ) {
            }

            public function name(): string
            {
                return 'collector-test';
            }

            public function manifest(): ModuleManifest
            {
                return ModuleManifest::make()
                    ->add($this->compiled)
                    ->add($this->runtime);
            }
        };

        $manifest = (new ManifestCollector())->collect([$module]);

        self::assertCount(1, $manifest->modules);

        $collectedModule = $manifest->modules[0];

        self::assertSame(
            [
                [
                    'type' => 'test',
                    'value' => 'compiled',
                ],
            ],
            $collectedModule->resources,
        );
    }
}


final class ManifestCollectorListenerEvent implements EventContract
{
}

final class ManifestCollectorListener
{
}
