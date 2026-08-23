<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Fingerprint;

use App\Core\Kernel\Compiler\CompiledModule;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Fingerprint\ManifestFingerprintGenerator;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class ManifestFingerprintGeneratorTest extends TestCase
{
    public function test_same_manifest_produces_same_fingerprint(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $manifest = $this->manifest('Test');

        self::assertSame(
            $generator->generate($manifest),
            $generator->generate($manifest),
        );
    }

    public function test_changed_manifest_produces_different_fingerprint(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $first = $generator->generate(
            $this->manifest('Test'),
        );

        $second = $generator->generate(
            $this->manifest('Changed'),
        );

        self::assertNotSame($first, $second);
    }

    public function test_changed_module_class_produces_different_fingerprint(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $first = new CompiledModuleManifest([
            new CompiledModule(
                class: 'Tests\\Fakes\\Kernel\\FakeModule',
                name: 'Test',
                dependencies: [],
                resources: [],
            ),
        ]);

        $second = new CompiledModuleManifest([
            new CompiledModule(
                class: 'Tests\\Fakes\\Kernel\\DependencyModule',
                name: 'Test',
                dependencies: [],
                resources: [],
            ),
        ]);

        self::assertNotSame(
            $generator->generate($first),
            $generator->generate($second),
        );
    }

    public function test_changed_dependencies_produce_different_fingerprint(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $first = new CompiledModuleManifest([
            new CompiledModule(
                class: FakeModule::class,
                name: 'Test',
                dependencies: [],
                resources: [],
            ),
        ]);

        $second = new CompiledModuleManifest([
            new CompiledModule(
                class: FakeModule::class,
                name: 'Test',
                dependencies: [
                    'Tests\\Fakes\\Kernel\\DependencyModule',
                ],
                resources: [],
            ),
        ]);

        self::assertNotSame(
            $generator->generate($first),
            $generator->generate($second),
        );
    }

    public function test_changed_resources_produce_different_fingerprint(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $first = new CompiledModuleManifest([
            new CompiledModule(
                class: FakeModule::class,
                name: 'Test',
                dependencies: [],
                resources: [],
            ),
        ]);

        $second = new CompiledModuleManifest([
            new CompiledModule(
                class: FakeModule::class,
                name: 'Test',
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

        self::assertNotSame(
            $generator->generate($first),
            $generator->generate($second),
        );
    }

    public function test_manifest_version_is_part_of_fingerprint_payload(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $manifest = $this->manifest('Test');

        $expected = hash(
            'sha256',
            json_encode(
                $manifest->toPayload(),
                JSON_THROW_ON_ERROR,
            ),
        );

        self::assertSame(
            $expected,
            $generator->generate($manifest),
        );
    }

    public function test_fingerprint_is_sha256_hex(): void
    {
        $generator = new ManifestFingerprintGenerator();

        $fingerprint = $generator->generate(
            $this->manifest('Test'),
        );

        self::assertSame(64, strlen($fingerprint));

        self::assertMatchesRegularExpression(
            '/^[a-f0-9]{64}$/',
            $fingerprint,
        );
    }

    private function manifest(string $name): CompiledModuleManifest
    {
        return new CompiledModuleManifest([
            new CompiledModule(
                class: FakeModule::class,
                name: $name,
                dependencies: [],
                resources: [],
            ),
        ]);
    }
}
