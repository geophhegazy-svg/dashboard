<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Inspector\KernelInspector;
use App\Core\Kernel\ModuleRegistry;
use App\Infrastructure\Laravel\Console\Kernel\KernelModulesCommand;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\Fakes\Kernel\FakeModule;
use Tests\TestCase;

final class KernelModulesCommandTest extends TestCase
{
    public function test_command_displays_kernel_modules_and_statistics(): void
    {
        $registry = new ModuleRegistry();

        $registry->add(
            new FakeModule('customer'),
        );

        $inspector = new KernelInspector(
            $registry,
        );

        $this->app->instance(
            ModuleRegistry::class,
            $registry,
        );

        $this->app->instance(
            KernelInspector::class,
            $inspector,
        );

        $command = $this->app->make(
            KernelModulesCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:modules'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString(
            'customer',
            $output,
        );

        self::assertStringContainsString(
            'FakeModule',
            $output,
        );

        self::assertStringContainsString(
            'Modules: 1 | Dependencies: 0 | Resources: 0',
            $output,
        );
    }
}
