<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheStatusCommand;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class KernelCacheStatusCommandTest extends TestCase
{
    public function test_command_reports_missing_cache(): void
    {
        $cache = new class implements ModuleManifestCacheInterface {
            public function has(): bool
            {
                return false;
            }

            public function load(): ?CompiledModuleManifest
            {
                return null;
            }

            public function save(
                CompiledModuleManifest $manifest,
            ): void {
            }

            public function clear(): void
            {
            }
        };

        $fingerprint = $this->createMock(
            ManifestFingerprintGeneratorInterface::class,
        );

        $this->app->instance(
            ModuleManifestCacheInterface::class,
            $cache,
        );

        $this->app->instance(
            ManifestFingerprintGeneratorInterface::class,
            $fingerprint,
        );

        $command = $this->app->make(
            KernelCacheStatusCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:cache-status'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        self::assertStringContainsString(
            'Missing',
            $tester->getDisplay(),
        );
    }

    public function test_command_reports_loaded_cache(): void
    {
        $manifest = new CompiledModuleManifest([]);

        $cache = new class($manifest) implements ModuleManifestCacheInterface {
            public function __construct(
                private CompiledModuleManifest $manifest,
            ) {
            }

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

        $fingerprint = new class implements ManifestFingerprintGeneratorInterface {
            public function generate(
                CompiledModuleManifest $manifest,
            ): string {
                return 'test-fingerprint';
            }
        };

        $this->app->instance(
            ModuleManifestCacheInterface::class,
            $cache,
        );

        $this->app->instance(
            ManifestFingerprintGeneratorInterface::class,
            $fingerprint,
        );

        $command = $this->app->make(
            KernelCacheStatusCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:cache-status'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString(
            'Available',
            $output,
        );

        self::assertStringContainsString(
            'Fingerprint',
            $output,
        );

        self::assertStringContainsString(
            'test-fingerprint',
            $output,
        );
    }
}
