<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Validation;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\Rules\DuplicateModuleClassRule;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;
use Tests\Fakes\Kernel\FakeBillingModule;
use Tests\Fakes\Kernel\FakeCustomerModule;


final class DuplicateModuleClassRuleTest extends TestCase
{
    public function test_it_detects_duplicate_module_classes(): void
    {
        $registry = new ModuleRegistry();

        $registry->add(
            new FakeModule('Customer'),
        );

        $registry->add(
            new FakeModule('Billing'),
        );

        $rule = new DuplicateModuleClassRule();

        $errors = $rule->validate(
            $registry,
        );

        $this->assertCount(
            1,
            $errors,
        );
    }

    public function test_it_allows_unique_module_classes(): void
    {
        $registry = new ModuleRegistry();

        $registry->add(
            new FakeCustomerModule(),
        );

        $registry->add(
            new FakeBillingModule(),
        );

        $rule = new DuplicateModuleClassRule();

        $errors = $rule->validate(
            $registry,
        );

        $this->assertEmpty(
            $errors,
        );
    }
}
