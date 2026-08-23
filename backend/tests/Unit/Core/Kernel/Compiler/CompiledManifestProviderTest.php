<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Compiler;

use App\Core\Kernel\Compiler\CollectedManifest;
use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Compiler\CompiledModule;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Compiler\ManifestCollector;
use App\Core\Kernel\Compiler\ModuleManifestCompiler;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\ModuleRegistry;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class CompiledManifestProviderTest extends TestCase
{
    public function test_cache_miss_compiles_saves_and_returns_compiled_manifest(): void
    {
        $cache = new TestCache(
            hasCache: false,
            loaded: null,
        );

        $fingerprint = new TestFingerprintGenerator();

        $provider = new CompiledManifestProvider(
            collector: new ManifestCollector(),
            compiler: new ModuleManifestCompiler(),
            cache: $cache,
            fingerprint: $fingerprint,
        );

        $result = $provider->provide(
            $this->registry(),
        );

        self::assertCount(1, $result->modules());
        self::assertSame('Test', $result->modules()[0]->name());

        self::assertSame(1, $cache->saveCalls);
        self::assertSame($result, $cache->saved);
    }

    public function test_matching_cache_returns_cached_manifest_without_saving(): void
    {
        $cached = $this->manifest('Test');

        $cache = new TestCache(
            hasCache: true,
            loaded: $cached,
        );

        $provider = new CompiledManifestProvider(
            collector: new ManifestCollector(),
            compiler: new ModuleManifestCompiler(),
            cache: $cache,
            fingerprint: new TestFingerprintGenerator(),
        );

        $result = $provider->provide(
            $this->registry(),
        );

        self::assertSame($cached, $result);
        self::assertSame(0, $cache->saveCalls);
    }

    public function test_stale_cache_is_replaced_with_current_manifest(): void
    {
        $cached = $this->manifest('Old');

        $cache = new TestCache(
            hasCache: true,
            loaded: $cached,
        );

        $provider = new CompiledManifestProvider(
            collector: new ManifestCollector(),
            compiler: new ModuleManifestCompiler(),
            cache: $cache,
            fingerprint: new TestFingerprintGenerator(),
        );

        $result = $provider->provide(
            $this->registry(),
        );

        self::assertSame('Test', $result->modules()[0]->name());

        self::assertSame(1, $cache->saveCalls);
        self::assertSame($result, $cache->saved);
        self::assertNotSame($cached, $result);
    }

    public function test_compiled_manifest_preserves_topological_module_order(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $subscription = new class($customer::class) extends FakeModule
        {
            public function __construct(
                string $dependency,
            ) {
                parent::__construct(
                    'Subscription',
                    [$dependency],
                );
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($customer);
        $registry->add($subscription);

        $provider = new CompiledManifestProvider(
            collector: new ManifestCollector(),
            compiler: new ModuleManifestCompiler(),
            cache: new TestCache(
                hasCache: false,
                loaded: null,
            ),
            fingerprint: new TestFingerprintGenerator(),
        );

        $manifest = $provider->provide($registry);

        self::assertCount(2, $manifest->modules());

        self::assertSame(
            $customer::class,
            $manifest->modules()[0]->class(),
        );

        self::assertSame(
            $subscription::class,
            $manifest->modules()[1]->class(),
        );

        self::assertSame(
            [$customer::class],
            $manifest->modules()[1]->dependencies(),
        );
    }

    public function test_cache_that_exists_but_cannot_be_loaded_is_rebuilt(): void
    {
        $cache = new TestCache(
            hasCache: true,
            loaded: null,
        );

        $provider = new CompiledManifestProvider(
            collector: new ManifestCollector(),
            compiler: new ModuleManifestCompiler(),
            cache: $cache,
            fingerprint: new TestFingerprintGenerator(),
        );

        $result = $provider->provide(
            $this->registry(),
        );

        self::assertCount(1, $result->modules());
        self::assertSame('Test', $result->modules()[0]->name());

        self::assertSame(1, $cache->saveCalls);
        self::assertSame($result, $cache->saved);
    }

    private function registry(): ModuleRegistry
    {
        $registry = new ModuleRegistry();

        $registry->add(
            new FakeModule('Test'),
        );

        return $registry;
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

final class TestCache implements ModuleManifestCacheInterface
{
    public int $saveCalls = 0;

    public ?CompiledModuleManifest $saved = null;

    public function __construct(
        private readonly bool $hasCache,
        private readonly ?CompiledModuleManifest $loaded,
    ) {}

    public function has(): bool
    {
        return $this->hasCache;
    }

    public function load(): ?CompiledModuleManifest
    {
        return $this->loaded;
    }

    public function save(
        CompiledModuleManifest $manifest,
    ): void {
        $this->saveCalls++;
        $this->saved = $manifest;
    }

    public function clear(): void
    {
    }
}

final class TestFingerprintGenerator implements ManifestFingerprintGeneratorInterface
{
    public function generate(
        CompiledModuleManifest $manifest,
    ): string {
        return hash(
            'sha256',
            json_encode(
                $manifest->toPayload(),
                JSON_THROW_ON_ERROR,
            ),
        );
    }
}
