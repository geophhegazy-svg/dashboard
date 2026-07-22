<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\PolicyResource;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;
use Mockery;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final class PolicyResourceTest extends TestCase
{
    public function test_it_registers_module_policies_with_the_gate(): void
    {
        $resource = new PolicyResource([
            PolicyResourceTestModel::class => PolicyResourceTestPolicy::class,
        ]);

        $registrar = $this->app->make(
            ModuleRegistrarInterface::class
        );

        $resource->register($registrar);

        $this->assertInstanceOf(
            PolicyResourceTestPolicy::class,
            Gate::getPolicyFor(PolicyResourceTestModel::class),
        );
    }
}

final class PolicyResourceTestModel
{
}

final class PolicyResourceTestPolicy
{
}
