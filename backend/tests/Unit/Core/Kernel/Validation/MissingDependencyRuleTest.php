<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Validation;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\Rules\MissingDependencyRule;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeBillingModule;
use Tests\Fakes\Kernel\FakeModule;

final class MissingDependencyRuleTest extends TestCase
{
    public function test_it_detects_missing_dependencies(): void
    {
        $missingDependency = FakeModule::class . 'Missing';

        $module = new FakeModule(
            'Billing',
            [
                $missingDependency,
            ],
        );

        $registry = new ModuleRegistry();

        $registry->add($module);

        $rule = new MissingDependencyRule();

        $errors = $rule->validate($registry);

        $this->assertCount(1, $errors);

        $this->assertSame(
            'missing_dependency',
            $errors[0]->code()->value,
        );
    }

    public function test_it_allows_existing_dependencies(): void
    {
        $billing = new FakeBillingModule();

        $customer = new FakeModule('Customer');

        /*
         * Use a concrete fake class as the dependency target.
         */
        $dependent = new FakeModule(
            'Dependent',
            [
                $customer::class,
            ],
        );

        $registry = new ModuleRegistry();

        $registry->add($dependent);
        $registry->add($customer);
        $registry->add($billing);

        $rule = new MissingDependencyRule();

        $errors = $rule->validate($registry);

        $this->assertEmpty($errors);
    }
}
