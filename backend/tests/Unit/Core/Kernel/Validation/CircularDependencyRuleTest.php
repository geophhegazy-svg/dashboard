<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Validation;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\Rules\CircularDependencyRule;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;

final class CircularDependencyRuleTest extends TestCase
{
    public function test_it_detects_circular_dependencies(): void
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

        $registry = new ModuleRegistry();

        $registry->add($module);

        $rule = new CircularDependencyRule();

        $errors = $rule->validate(
            $registry
        );

        $this->assertCount(1, $errors);

        $this->assertSame(
            'circular_dependency',
            $errors[0]->code()->value,
        );
    }

    public function test_it_allows_valid_dependency_graphs(): void
    {
        $customer = new class extends FakeModule
        {
            public function __construct()
            {
                parent::__construct('Customer');
            }
        };

        $subscription = new class($customer::class)
            extends FakeModule
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

        $registry = new ModuleRegistry();

        $registry->add($subscription);
        $registry->add($customer);

        $rule = new CircularDependencyRule();

        $errors = $rule->validate(
            $registry
        );

        $this->assertEmpty($errors);
    }
}
