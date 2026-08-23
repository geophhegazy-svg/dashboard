<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Modules\Module;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheCommand;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class KernelCacheCommandTest extends TestCase
{
    public function test_command_builds_and_caches_manifest(): void
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

        $fingerprint = new class implements ManifestFingerprintGeneratorInterface {
            public function generate(
                CompiledModuleManifest $manifest,
            ): string {
                return 'test-fingerprint';
            }
        };

        $provider = new CompiledManifestProvider(
            collector: new \App\Core\Kernel\Compiler\ManifestCollector(),
            compiler: new \App\Core\Kernel\Compiler\ModuleManifestCompiler(),
            cache: $cache,
            fingerprint: $fingerprint,
        );

        $registry = new ModuleRegistry();

        $this->app->instance(
            CompiledManifestProvider::class,
            $provider,
        );

        $this->app->instance(
            ModuleRegistry::class,
            $registry,
        );

        $command = $this->app->make(
            KernelCacheCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:cache'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString(
            'Kernel manifest cached successfully.',
            $output,
        );

        self::assertStringContainsString(
            'Modules',
            $output,
        );

        self::assertStringContainsString(
            'Cached',
            $output,
        );
    }
}
