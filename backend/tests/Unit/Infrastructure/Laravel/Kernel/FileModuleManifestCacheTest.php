<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Kernel;

use App\Core\Kernel\Compiler\CompiledModule;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Infrastructure\Laravel\Kernel\FileModuleManifestCache;
use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

final class FileModuleManifestCacheTest extends TestCase
{
    public function test_has_delegates_to_filesystem(): void
    {
        $filesystem = $this->createMock(Filesystem::class);

        $filesystem
            ->expects($this->once())
            ->method('exists')
            ->with(base_path('cache/kernel-manifest.json'))
            ->willReturn(true);

        $cache = new FileModuleManifestCache($filesystem);

        self::assertTrue($cache->has());
    }

    public function test_load_returns_null_when_cache_file_is_missing(): void
    {
        $filesystem = $this->createMock(Filesystem::class);

        $filesystem
            ->expects($this->once())
            ->method('exists')
            ->with(base_path('cache/kernel-manifest.json'))
            ->willReturn(false);

        $cache = new FileModuleManifestCache($filesystem);

        self::assertNull($cache->load());
    }

    public function test_load_rehydrates_compiled_manifest_from_json_payload(): void
    {
        $payload = [
            'version' => 1,
            'modules' => [
                [
                    'class' => 'Tests\\Fakes\\Kernel\\FakeModule',
                    'name' => 'Fake',
                    'dependencies' => [
                        'Tests\\Fakes\\Kernel\\DependencyModule',
                    ],
                    'resources' => [
                        [
                            'type' => 'services',
                            'bindings' => [
                                'FooInterface' => 'FooService',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $filesystem = $this->createMock(Filesystem::class);

        $filesystem
            ->expects($this->once())
            ->method('exists')
            ->with(base_path('cache/kernel-manifest.json'))
            ->willReturn(true);

        $filesystem
            ->expects($this->once())
            ->method('get')
            ->with(base_path('cache/kernel-manifest.json'))
            ->willReturn(json_encode($payload, JSON_THROW_ON_ERROR));

        $cache = new FileModuleManifestCache($filesystem);

        $manifest = $cache->load();

        self::assertInstanceOf(
            CompiledModuleManifest::class,
            $manifest,
        );

        self::assertSame(1, $manifest->count());

        $module = $manifest->findByName('Fake');

        self::assertNotNull($module);

        self::assertSame(
            'Tests\\Fakes\\Kernel\\FakeModule',
            $module->class(),
        );

        self::assertSame(
            ['Tests\\Fakes\\Kernel\\DependencyModule'],
            $module->dependencies(),
        );

        self::assertSame(
            $payload['modules'][0]['resources'],
            $module->resources(),
        );
    }

    public function test_save_serializes_manifest_and_creates_cache_directory(): void
    {
        $manifest = new CompiledModuleManifest([
            new CompiledModule(
                class: 'Tests\\Fakes\\Kernel\\FakeModule',
                name: 'Fake',
                dependencies: [],
                resources: [
                    [
                        'type' => 'services',
                        'bindings' => [
                            'FooInterface' => 'FooService',
                        ],
                    ],
                ],
            ),
        ]);

        $filesystem = $this->createMock(Filesystem::class);

        $filesystem
            ->expects($this->once())
            ->method('ensureDirectoryExists')
            ->with(dirname(base_path('cache/kernel-manifest.json')));

        $filesystem
            ->expects($this->once())
            ->method('put')
            ->with(
                base_path('cache/kernel-manifest.json'),
                json_encode(
                    $manifest->toPayload(),
                    JSON_PRETTY_PRINT
                        | JSON_UNESCAPED_SLASHES
                        | JSON_THROW_ON_ERROR,
                ),
            );

        $cache = new FileModuleManifestCache($filesystem);

        $cache->save($manifest);
    }

    public function test_clear_deletes_cache_file(): void
    {
        $filesystem = $this->createMock(Filesystem::class);

        $filesystem
            ->expects($this->once())
            ->method('delete')
            ->with(base_path('cache/kernel-manifest.json'));

        $cache = new FileModuleManifestCache($filesystem);

        $cache->clear();
    }

    public function test_manifest_payload_round_trip_preserves_structure(): void
    {
        $manifest = new CompiledModuleManifest([
            new CompiledModule(
                class: 'Tests\\Fakes\\Kernel\\FakeModule',
                name: 'Fake',
                dependencies: [
                    'Tests\\Fakes\\Kernel\\DependencyModule',
                ],
                resources: [
                    [
                        'type' => 'services',
                        'bindings' => [
                            'FooInterface' => 'FooService',
                        ],
                    ],
                ],
            ),
        ]);

        $rehydrated = CompiledModuleManifest::fromPayload(
            json_decode(
                json_encode(
                    $manifest->toPayload(),
                    JSON_THROW_ON_ERROR,
                ),
                true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );

        self::assertSame(
            $manifest->toPayload(),
            $rehydrated->toPayload(),
        );
    }

    public function test_load_rejects_unsupported_manifest_version(): void
    {
        $filesystem = $this->createMock(Filesystem::class);

        $filesystem
            ->expects($this->once())
            ->method('exists')
            ->with(base_path('cache/kernel-manifest.json'))
            ->willReturn(true);

        $filesystem
            ->expects($this->once())
            ->method('get')
            ->with(base_path('cache/kernel-manifest.json'))
            ->willReturn(
                json_encode([
                    'version' => 999,
                    'modules' => [],
                ], JSON_THROW_ON_ERROR),
            );

        $cache = new FileModuleManifestCache($filesystem);

        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'Unsupported compiled module manifest version.'
        );

        $cache->load();
    }
}
