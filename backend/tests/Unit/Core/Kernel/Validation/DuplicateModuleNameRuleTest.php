<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Validation;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\Rules\DuplicateModuleNameRule;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Kernel\FakeModule;


final class DuplicateModuleNameRuleTest extends TestCase
{
    public function test_it_detects_duplicate_module_names(): void
    {
        $registry = new ModuleRegistry();

        $registry->add(
            new FakeModule('Customer'),
        );

        $registry->add(
            new FakeModule('Customer'),
        );

        $rule = new DuplicateModuleNameRule();

        $errors = $rule->validate(
            $registry,
        );

        $this->assertCount(
            1,
            $errors,
        );
    }

    public function test_it_allows_unique_module_names(): void
    {
        $registry = new ModuleRegistry();

        $registry->add(
            new FakeModule('Customer'),
        );

        $registry->add(
            new FakeModule('Billing'),
        );

        $rule = new DuplicateModuleNameRule();

        $errors = $rule->validate(
            $registry,
        );

        $this->assertEmpty(
            $errors,
        );
    }
}
