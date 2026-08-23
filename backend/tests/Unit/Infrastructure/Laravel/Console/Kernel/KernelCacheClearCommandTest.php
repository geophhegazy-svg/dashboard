<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheClearCommand;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class KernelCacheClearCommandTest extends TestCase
{
    public function test_command_clears_existing_kernel_manifest_cache(): void
    {
        $cache = new class implements ModuleManifestCacheInterface {
            public bool $cleared = false;

            public function has(): bool
            {
                return true;
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
                $this->cleared = true;
            }
        };

        $this->app->instance(
            ModuleManifestCacheInterface::class,
            $cache,
        );

        $command = $this->app->make(
            KernelCacheClearCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:cache-clear'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);
        self::assertTrue($cache->cleared);

        self::assertStringContainsString(
            'Kernel manifest cache cleared successfully.',
            $tester->getDisplay(),
        );
    }

    public function test_command_does_not_clear_when_kernel_manifest_cache_is_empty(): void
    {
        $cache = new class implements ModuleManifestCacheInterface {
            public bool $cleared = false;

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
                $this->cleared = true;
            }
        };

        $this->app->instance(
            ModuleManifestCacheInterface::class,
            $cache,
        );

        $command = $this->app->make(
            KernelCacheClearCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:cache-clear'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);
        self::assertFalse($cache->cleared);

        self::assertStringContainsString(
            'Kernel manifest cache is already empty.',
            $tester->getDisplay(),
        );
    }
}
