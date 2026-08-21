<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel;

use App\Core\Kernel\ModuleRegistry;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class ModuleRegistryTest extends TestCase
{
    public function test_it_starts_empty(): void
    {
        $registry = new ModuleRegistry();

        $this->assertTrue(
            $registry->isEmpty(),
        );

        $this->assertSame(
            0,
            $registry->count(),
        );

        $this->assertSame(
            [],
            $registry->all(),
        );
    }


    public function test_it_adds_and_returns_modules_in_insertion_order(): void
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

        $registry = new ModuleRegistry();

        $registry->add($customer);
        $registry->add($billing);

        $modules = $registry->all();

        $this->assertCount(2, $modules);

        $this->assertSame(
            $customer,
            $modules[0],
        );

        $this->assertSame(
            $billing,
            $modules[1],
        );

        $this->assertSame(
            2,
            $registry->count(),
        );
    }


    public function test_it_resolves_module_identity_by_class(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($customer);

        $this->assertTrue(
            $registry->has($customer::class),
        );

        $this->assertSame(
            $customer,
            $registry->get($customer::class),
        );
    }


    public function test_it_returns_false_and_null_for_unknown_module(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($customer);

        $missing = 'Tests\\Fakes\\Kernel\\MissingModule';

        $this->assertFalse(
            $registry->has($missing),
        );

        $this->assertNull(
            $registry->get($missing),
        );
    }


    public function test_it_preserves_duplicate_entries_for_validation(): void
    {
        $customerA = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $customerB = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($customerA);
        $registry->add($customerB);

        $this->assertSame(
            2,
            $registry->count(),
        );

        $this->assertCount(
            2,
            $registry->all(),
        );
    }


    public function test_it_resets_all_registered_modules(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $registry = new ModuleRegistry();

        $registry->add($customer);

        $this->assertFalse(
            $registry->isEmpty(),
        );

        $registry->reset();

        $this->assertTrue(
            $registry->isEmpty(),
        );

        $this->assertSame(
            0,
            $registry->count(),
        );

        $this->assertSame(
            [],
            $registry->all(),
        );
    }
}
