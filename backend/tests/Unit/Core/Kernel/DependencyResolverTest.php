<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel;

use App\Core\Kernel\DependencyResolver;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Fakes\Kernel\FakeModule;

final class DependencyResolverTest extends TestCase
{
    public function test_it_resolves_dependencies_before_dependents(): void
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

        $resolver = new DependencyResolver();

        $resolved = $resolver->resolve([
            $subscription,
            $customer,
        ]);

        $this->assertCount(2, $resolved);

        $this->assertSame(
            $customer::class,
            $resolved[0]::class,
        );

        $this->assertSame(
            $subscription::class,
            $resolved[1]::class,
        );
    }

    public function test_it_resolves_independent_modules(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $billing = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Billing');
            }
        };

        $resolver = new DependencyResolver();

        $resolved = $resolver->resolve([
            $customer,
            $billing,
        ]);

        $this->assertCount(2, $resolved);

        $this->assertSame(
            $customer::class,
            $resolved[0]::class,
        );

        $this->assertSame(
            $billing::class,
            $resolved[1]::class,
        );
    }

    public function test_it_rejects_missing_dependencies(): void
    {
        $missingDependency =
            'Tests\\Fakes\\Kernel\\MissingModule';

        $billing = new class($missingDependency) extends FakeModule
        {
            public function __construct(
                string $dependency,
            ) {
                parent::__construct(
                    'Billing',
                    [$dependency],
                );
            }
        };

        $resolver = new DependencyResolver();

        $this->expectException(
            RuntimeException::class
        );

        $this->expectExceptionMessage(
            "Missing dependency [{$missingDependency}] required by ["
            . $billing::class
            . "]."
        );

        $resolver->resolve([
            $billing,
        ]);
    }

    public function test_it_rejects_circular_dependencies(): void
    {
        $module = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct(
                    'Circular',
                    [
                        self::class,
                    ],
                );
            }
        };

        $resolver = new DependencyResolver();

        $this->expectException(
            RuntimeException::class
        );

        $this->expectExceptionMessage(
            'Circular dependency detected'
        );

        $resolver->resolve([
            $module,
        ]);
    }
}
