<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Diagnostics;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Diagnostics\KernelDiagnostics;
use App\Core\Kernel\Inspector\KernelInspector;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use Tests\TestCase;

final class KernelDiagnosticsTest extends TestCase
{
    public function test_it_does_not_expose_cached_manifest_before_successful_boot(): void
    {
        $cachedManifest = new CompiledModuleManifest([]);

        $cache = new class($cachedManifest) implements ModuleManifestCacheInterface {
            public function __construct(
                private readonly CompiledModuleManifest $manifest,
            ) {}

            public function has(): bool
            {
                return true;
            }

            public function load(): ?CompiledModuleManifest
            {
                return $this->manifest;
            }

            public function save(
                CompiledModuleManifest $manifest,
            ): void {
            }

            public function clear(): void
            {
            }
        };

        $fingerprint = new class
            implements ManifestFingerprintGeneratorInterface
        {
            public function generate(
                CompiledModuleManifest $manifest,
            ): string {
                return 'cached-fingerprint';
            }
        };

        $inspector = new KernelInspector(
            new ModuleRegistry(),
        );

        $runtime = new KernelRuntimeState();

        $lifecycle = new KernelLifecycleManager();

        $diagnostics = new KernelDiagnostics(
            inspector: $inspector,
            cache: $cache,
            fingerprint: $fingerprint,
            runtime: $runtime,
            lifecycle: $lifecycle,
        );

        $report = $diagnostics->generate();

        self::assertFalse($report->booted());
        self::assertFalse($report->manifestAvailable());
        self::assertNull($report->fingerprint());
        self::assertNull($report->bootedAt());
    }

    public function test_it_hides_runtime_manifest_after_runtime_reset(): void
    {
        $manifest = new CompiledModuleManifest([]);

        $cache = new class implements ModuleManifestCacheInterface {
            public function has(): bool
            {
                return true;
            }

            public function load(): ?CompiledModuleManifest
            {
                return new CompiledModuleManifest([]);
            }

            public function save(
                CompiledModuleManifest $manifest,
            ): void {
            }

            public function clear(): void
            {
            }
        };

        $fingerprint = new class
            implements ManifestFingerprintGeneratorInterface
        {
            public function generate(
                CompiledModuleManifest $manifest,
            ): string {
                return 'runtime-fingerprint';
            }
        };

        $inspector = new KernelInspector(
            new ModuleRegistry(),
        );

        $runtime = new KernelRuntimeState();

        $runtime->set(
            new \App\Core\Kernel\Runtime\KernelRuntimeContext(
                manifest: $manifest,
                bootedAt: new \DateTimeImmutable(
                    '2026-08-22 20:00:00',
                ),
            ),
        );

        self::assertTrue($runtime->isBooted());

        $runtime->reset();

        $lifecycle = new KernelLifecycleManager();

        $diagnostics = new KernelDiagnostics(
            inspector: $inspector,
            cache: $cache,
            fingerprint: $fingerprint,
            runtime: $runtime,
            lifecycle: $lifecycle,
        );

        $report = $diagnostics->generate();

        self::assertFalse($report->booted());
        self::assertFalse($report->manifestAvailable());
        self::assertNull($report->fingerprint());
        self::assertNull($report->bootedAt());
    }


    public function test_ready_lifecycle_requires_initialized_runtime_to_report_booted(): void
    {
        $manifest = new CompiledModuleManifest([]);

        $cache = new class implements ModuleManifestCacheInterface {
            public function has(): bool
            {
                return true;
            }

            public function load(): ?CompiledModuleManifest
            {
                return new CompiledModuleManifest([]);
            }

            public function save(
                CompiledModuleManifest $manifest,
            ): void {
            }

            public function clear(): void
            {
            }
        };

        $fingerprint = new class
            implements ManifestFingerprintGeneratorInterface
        {
            public function generate(
                CompiledModuleManifest $manifest,
            ): string {
                return 'runtime-fingerprint';
            }
        };

        $inspector = new KernelInspector(
            new ModuleRegistry(),
        );

        $runtime = new KernelRuntimeState();

        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            \App\Core\Kernel\Lifecycle\KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            \App\Core\Kernel\Lifecycle\KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            \App\Core\Kernel\Lifecycle\KernelLifecycleState::Ready,
        );

        $diagnostics = new KernelDiagnostics(
            inspector: $inspector,
            cache: $cache,
            fingerprint: $fingerprint,
            runtime: $runtime,
            lifecycle: $lifecycle,
        );

        $report = $diagnostics->generate();

        self::assertFalse($report->booted());
        self::assertSame('ready', $report->lifecycle());
        self::assertFalse($report->manifestAvailable());
        self::assertNull($report->fingerprint());
        self::assertNull($report->bootedAt());
    }

    public function test_failed_lifecycle_with_reset_runtime_does_not_report_booted(): void
    {
        $manifest = new CompiledModuleManifest([]);

        $cache = new class implements ModuleManifestCacheInterface {
            public function has(): bool
            {
                return true;
            }

            public function load(): ?CompiledModuleManifest
            {
                return $this->manifest();
            }

            public function save(
                CompiledModuleManifest $manifest,
            ): void {
            }

            public function clear(): void
            {
            }

            private function manifest(): CompiledModuleManifest
            {
                return new CompiledModuleManifest([]);
            }
        };

        $fingerprint = new class
            implements ManifestFingerprintGeneratorInterface
        {
            public function generate(
                CompiledModuleManifest $manifest,
            ): string {
                return 'should-not-be-visible';
            }
        };

        $inspector = new KernelInspector(
            new ModuleRegistry(),
        );

        $runtime = new KernelRuntimeState();

        $runtime->set(
            new \App\Core\Kernel\Runtime\KernelRuntimeContext(
                manifest: $manifest,
                bootedAt: new \DateTimeImmutable(
                    '2026-08-23 20:00:00',
                ),
            ),
        );

        $runtime->reset();

        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            \App\Core\Kernel\Lifecycle\KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            \App\Core\Kernel\Lifecycle\KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            \App\Core\Kernel\Lifecycle\KernelLifecycleState::Failed,
        );

        $diagnostics = new KernelDiagnostics(
            inspector: $inspector,
            cache: $cache,
            fingerprint: $fingerprint,
            runtime: $runtime,
            lifecycle: $lifecycle,
        );

        $report = $diagnostics->generate();

        self::assertFalse($report->booted());
        self::assertSame('failed', $report->lifecycle());
        self::assertFalse($report->manifestAvailable());
        self::assertNull($report->fingerprint());
        self::assertNull($report->bootedAt());
    }

}
