<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Discovery;

use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Discovery\Contracts\ModuleSourceInterface;
use App\Core\Kernel\Discovery\ModuleDiscovery;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Fakes\Kernel\FakeModule;

final class ModuleDiscoveryTest extends TestCase
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

        $discovery = new ModuleDiscovery(
            new class([
                $subscription,
                $customer,
            ]) implements ModuleSourceInterface
            {
                public function __construct(
                    private array $modules,
                ) {}

                public function modules(): iterable
                {
                    return $this->modules;
                }
            },
        );

        $resolved = $discovery->discover();

        $resolved = array_values($resolved);

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

    public function test_it_preserves_order_for_independent_modules(): void
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

        $discovery = new ModuleDiscovery(
            new class([
                $customer,
                $billing,
            ]) implements ModuleSourceInterface
            {
                public function __construct(
                    private array $modules,
                ) {}

                public function modules(): iterable
                {
                    return $this->modules;
                }
            },
        );

        $resolved = array_values(
            $discovery->discover(),
        );

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

        $discovery = new ModuleDiscovery(
            new class([
                $billing,
            ]) implements ModuleSourceInterface
            {
                public function __construct(
                    private array $modules,
                ) {}

                public function modules(): iterable
                {
                    return $this->modules;
                }
            },
        );

        $this->expectException(
            RuntimeException::class,
        );

        $this->expectExceptionMessage(
            "Missing module dependency: {$missingDependency}",
        );

        $discovery->discover();
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

        $discovery = new ModuleDiscovery(
            new class([
                $module,
            ]) implements ModuleSourceInterface
            {
                public function __construct(
                    private array $modules,
                ) {}

                public function modules(): iterable
                {
                    return $this->modules;
                }
            },
        );

        $this->expectException(
            RuntimeException::class,
        );

        $this->expectExceptionMessage(
            'Circular module dependency detected',
        );

        $discovery->discover();
    }

    public function test_it_implements_the_discovery_contract(): void
    {
        $discovery = new ModuleDiscovery(
            new class implements ModuleSourceInterface
            {
                public function modules(): iterable
                {
                    return [];
                }
            },
        );

        $this->assertInstanceOf(
            ModuleDiscoveryInterface::class,
            $discovery,
        );
    }
}
