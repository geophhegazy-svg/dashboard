<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Compiler;

use App\Core\Kernel\Compiler\CollectedManifest;
use App\Core\Kernel\Compiler\CollectedModule;
use App\Core\Kernel\Compiler\ModuleManifestCompiler;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class ModuleManifestCompilerTest extends TestCase
{
    public function test_it_compiles_collected_module_without_losing_semantics(): void
    {
        $manifest = new CollectedManifest([
            new CollectedModule(
                class: FakeModule::class,
                name: 'Test',
                dependencies: [
                    'Tests\\Fakes\\Kernel\\DependencyModule',
                ],
                resources: [
                    [
                        'type' => 'listeners',
                        'listeners' => [
                            'TestEvent' => [
                                'TestListener',
                            ],
                        ],
                    ],
                ],
            ),
        ]);

        $compiled = (new ModuleManifestCompiler())->compile($manifest);

        self::assertCount(1, $compiled->modules());

        $module = $compiled->modules()[0];

        self::assertSame(
            FakeModule::class,
            $module->class(),
        );

        self::assertSame(
            'Test',
            $module->name(),
        );

        self::assertSame(
            [
                'Tests\\Fakes\\Kernel\\DependencyModule',
            ],
            $module->dependencies(),
        );

        self::assertSame(
            [
                [
                    'type' => 'listeners',
                    'listeners' => [
                        'TestEvent' => [
                            'TestListener',
                        ],
                    ],
                ],
            ],
            $module->resources(),
        );
    }

    public function test_empty_collected_manifest_compiles_to_empty_manifest(): void
    {
        $compiled = (new ModuleManifestCompiler())->compile(
            new CollectedManifest([]),
        );

        self::assertTrue($compiled->isEmpty());
        self::assertSame(0, $compiled->count());
    }

    public function test_compiler_preserves_module_order(): void
    {
        $manifest = new CollectedManifest([
            new CollectedModule(
                class: 'Tests\\Fakes\\Kernel\\FirstModule',
                name: 'First',
                dependencies: [],
                resources: [],
            ),
            new CollectedModule(
                class: 'Tests\\Fakes\\Kernel\\SecondModule',
                name: 'Second',
                dependencies: [
                    'Tests\\Fakes\\Kernel\\FirstModule',
                ],
                resources: [],
            ),
        ]);

        $compiled = (new ModuleManifestCompiler())->compile($manifest);

        self::assertSame(
            'First',
            $compiled->modules()[0]->name(),
        );

        self::assertSame(
            'Second',
            $compiled->modules()[1]->name(),
        );
    }
}
