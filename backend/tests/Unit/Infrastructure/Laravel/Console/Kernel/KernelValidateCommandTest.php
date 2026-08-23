<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\ValidationResult;
use App\Infrastructure\Laravel\Console\Kernel\KernelValidateCommand;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class KernelValidateCommandTest extends TestCase
{
    public function test_command_resets_loader_before_loading_modules(): void
    {
        $calls = [];

        $registry = new ModuleRegistry();

        $loader = new class($registry, $calls) implements ModuleLoaderInterface {
            public function __construct(
                private ModuleRegistry $registry,
                private array &$calls,
            ) {}

            public function load(): ModuleRegistry
            {
                $this->calls[] = 'load';

                return $this->registry;
            }

            public function reset(): void
            {
                $this->calls[] = 'reset';
            }
        };

        $validator = new class($registry, $calls) implements KernelValidatorInterface {
            public function __construct(
                private ModuleRegistry $registry,
                private array &$calls,
            ) {}

            public function validate(
                ModuleRegistry $registry,
            ): ValidationResult {
                $this->calls[] = 'validate';

                return new ValidationResult([]);
            }
        };

        $this->app->instance(
            ModuleLoaderInterface::class,
            $loader,
        );

        $this->app->instance(
            KernelValidatorInterface::class,
            $validator,
        );

        $command = $this->app->make(
            KernelValidateCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester(
            $application->find('kernel:validate'),
        );

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        self::assertSame(
            [
                'reset',
                'load',
                'validate',
            ],
            $calls,
        );

        self::assertStringContainsString(
            'Kernel validation passed.',
            $tester->getDisplay(),
        );
    }
}
