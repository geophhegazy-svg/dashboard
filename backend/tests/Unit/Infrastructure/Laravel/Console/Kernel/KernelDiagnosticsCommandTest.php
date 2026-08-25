<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Diagnostics\KernelDiagnostics;
use App\Core\Kernel\Inspector\KernelInspector;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Runtime\KernelRuntimeContext;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Infrastructure\Laravel\Console\Kernel\KernelDiagnosticsCommand;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\Fakes\Kernel\FakeModule;
use Tests\TestCase;

final class KernelDiagnosticsCommandTest extends TestCase
{
    public function test_command_displays_kernel_diagnostics(): void
    {
        $manifest = new CompiledModuleManifest([]);

        $cache = new class($manifest) implements ModuleManifestCacheInterface {
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
                return 'test-fingerprint';
            }
        };

        $registry = new ModuleRegistry();

        $registry->add(
            new FakeModule('customer'),
        );

        $inspector = new KernelInspector(
            $registry,
        );

        $runtime = new KernelRuntimeState();

        $runtime->set(
            new KernelRuntimeContext(
                manifest: $manifest,
                bootedAt: new \DateTimeImmutable(
                    '2026-08-22 20:00:00',
                ),
            ),
        );

        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Ready,
        );

        $diagnostics = new KernelDiagnostics(
            inspector: $inspector,
            cache: $cache,
            fingerprint: $fingerprint,
            runtime: $runtime,
            lifecycle: $lifecycle,
        );

        $this->app->instance(
            KernelDiagnostics::class,
            $diagnostics,
        );

        $command = $this->app->make(
            KernelDiagnosticsCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:diagnostics'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString('Modules', $output);
        self::assertStringContainsString('1', $output);

        self::assertStringContainsString('Resources', $output);
        self::assertStringContainsString('0', $output);

        self::assertStringContainsString('Dependencies', $output);
        self::assertStringContainsString('0', $output);

        self::assertStringContainsString('Booted', $output);
        self::assertStringContainsString('Available', $output);

        self::assertStringContainsString(
            'test-fingerprint',
            $output,
        );

        self::assertStringContainsString(
            'ready',
            $output,
        );
    }

    public function test_command_displays_na_when_runtime_has_not_booted(): void
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

        $lifecycle = new KernelLifecycleManager();

        $diagnostics = new KernelDiagnostics(
            inspector: $inspector,
            cache: $cache,
            fingerprint: $fingerprint,
            runtime: $runtime,
            lifecycle: $lifecycle,
        );

        $this->app->instance(
            KernelDiagnostics::class,
            $diagnostics,
        );

        $command = $this->app->make(
            KernelDiagnosticsCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:diagnostics'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString(
            'Not Booted',
            $output,
        );

        self::assertStringContainsString(
            'N/A',
            $output,
        );

        self::assertStringContainsString(
            'Missing',
            $output,
        );
    }

}
