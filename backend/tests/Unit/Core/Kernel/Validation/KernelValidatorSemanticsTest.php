<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Validation;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\KernelValidationRuleRegistry;
use App\Core\Kernel\Validation\KernelValidator;
use App\Core\Kernel\Validation\Rules\CircularDependencyRule;
use App\Core\Kernel\Validation\Rules\MissingDependencyRule;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class KernelValidatorSemanticsTest extends TestCase
{
    public function test_validation_does_not_mutate_registry_order(): void
    {
        $first = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('first');
            }

            public function name(): string
            {
                return 'first';
            }
        };

        $second = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('second');
            }

            public function name(): string
            {
                return 'second';
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($first);
        $registry->add($second);

        $rules = new KernelValidationRuleRegistry(
            new class implements \App\Core\Contracts\ContainerInterface
            {
                public function get(string $id): mixed
                {
                    return new $id();
                }

                public function has(string $id): bool
                {
                    return true;
                }

                public function make(string $abstract): object
                {
                    return new $abstract();
                }
            },
            [
                CircularDependencyRule::class,
                MissingDependencyRule::class,
            ],
        );

        $validator = new KernelValidator($rules);

        $before = array_map(
            static fn($module) => $module::class,
            $registry->all(),
        );

        $validator->validate($registry);

        $after = array_map(
            static fn($module) => $module::class,
            $registry->all(),
        );

        self::assertSame($before, $after);
    }

    public function test_validation_does_not_remove_modules(): void
    {
        $first = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('first');
            }

            public function name(): string
            {
                return 'first';
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($first);

        $rules = new KernelValidationRuleRegistry(
            new class implements \App\Core\Contracts\ContainerInterface
            {
                public function get(string $id): mixed
                {
                    return new $id();
                }

                public function has(string $id): bool
                {
                    return true;
                }

                public function make(string $abstract): object
                {
                    return new $abstract();
                }
            },
            [
                CircularDependencyRule::class,
                MissingDependencyRule::class,
            ],
        );

        $validator = new KernelValidator($rules);

        $validator->validate($registry);

        self::assertCount(1, $registry->all());
        self::assertSame($first, $registry->all()[0]);
    }
}
