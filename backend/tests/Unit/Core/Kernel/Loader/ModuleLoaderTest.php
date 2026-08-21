<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Loader;

use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Loader\ModuleLoader;
use App\Core\Kernel\ModuleRegistry;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class ModuleLoaderTest extends TestCase
{
    public function test_it_loads_discovered_modules_into_registry(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $subscription = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Subscription');
            }
        };

        $registry = new ModuleRegistry();

        $discovery = new class([
            $customer,
            $subscription,
        ]) implements ModuleDiscoveryInterface
        {
            public function __construct(
                private array $modules,
            ) {}

            public function discover(): iterable
            {
                return $this->modules;
            }
        };

        $loader = new ModuleLoader(
            $discovery,
            $registry,
        );

        $result = $loader->load();

        $this->assertSame(
            $registry,
            $result,
        );

        $this->assertCount(
            2,
            $registry->all(),
        );

        $this->assertSame(
            $customer::class,
            $registry->all()[0]::class,
        );

        $this->assertSame(
            $subscription::class,
            $registry->all()[1]::class,
        );
    }


    public function test_it_preserves_discovery_order(): void
    {
        $first = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('First');
            }
        };

        $second = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Second');
            }
        };

        $third = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Third');
            }
        };

        $registry = new ModuleRegistry();

        $discovery = new class([
            $first,
            $second,
            $third,
        ]) implements ModuleDiscoveryInterface
        {
            public function __construct(
                private array $modules,
            ) {}

            public function discover(): iterable
            {
                return $this->modules;
            }
        };

        $loader = new ModuleLoader(
            $discovery,
            $registry,
        );

        $loader->load();

        $modules = $registry->all();

        $this->assertSame(
            $first::class,
            $modules[0]::class,
        );

        $this->assertSame(
            $second::class,
            $modules[1]::class,
        );

        $this->assertSame(
            $third::class,
            $modules[2]::class,
        );
    }


    public function test_it_resets_the_registry(): void
    {
        $module = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $registry = new ModuleRegistry();

        $discovery = new class([
            $module,
        ]) implements ModuleDiscoveryInterface
        {
            public function __construct(
                private array $modules,
            ) {}

            public function discover(): iterable
            {
                return $this->modules;
            }
        };

        $loader = new ModuleLoader(
            $discovery,
            $registry,
        );

        $loader->load();

        $this->assertFalse(
            $registry->isEmpty(),
        );

        $loader->reset();

        $this->assertTrue(
            $registry->isEmpty(),
        );

        $this->assertCount(
            0,
            $registry->all(),
        );
    }


    public function test_it_implements_the_loader_contract(): void
    {
        $loader = new ModuleLoader(
            new class implements ModuleDiscoveryInterface
            {
                public function discover(): iterable
                {
                    return [];
                }
            },
            new ModuleRegistry(),
        );

        $this->assertInstanceOf(
            ModuleLoaderInterface::class,
            $loader,
        );
    }
}
