<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;
use App\Models\User;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Subscription\Kernel\SubscriptionModule;
use App\Modules\Subscription\Policies\SubscriptionPolicy;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

final class SubscriptionPolicyRegistrationTest extends TestCase
{
    public function test_subscription_policy_is_registered(): void
    {
        $module = app(SubscriptionModule::class);

        $manifest = $module->manifest();

        $registrar = app(LaravelModuleRegistrar::class);

        foreach ($manifest->resources() as $resource) {
            $resource->register($registrar);
        }

        $policy = Gate::getPolicyFor(
            Subscription::class
        );

        $this->assertInstanceOf(
            SubscriptionPolicy::class,
            $policy
        );
    }

    public function test_subscription_policy_exposes_expected_permissions(): void
    {
        $policy = new SubscriptionPolicy();

        $user = new User();

        $subscription = new Subscription();

        Gate::shouldReceive('check')
            ->never();

        $this->assertTrue(
            method_exists($policy, 'viewAny')
        );

        $this->assertTrue(
            method_exists($policy, 'view')
        );

        $this->assertTrue(
            method_exists($policy, 'create')
        );

        $this->assertTrue(
            method_exists($policy, 'update')
        );

        $this->assertTrue(
            method_exists($policy, 'delete')
        );

        $this->assertTrue(
            method_exists($policy, 'activate')
        );

        $this->assertTrue(
            method_exists($policy, 'suspend')
        );

        $this->assertTrue(
            method_exists($policy, 'renew')
        );

        $this->assertTrue(
            method_exists($policy, 'restore')
        );

        $this->assertTrue(
            method_exists($policy, 'expire')
        );
    }
}
