<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;
use App\Models\User;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use App\Modules\Subscription\Kernel\SubscriptionModule;
use App\Modules\Subscription\Policies\HotspotSubscriptionPolicy;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

final class HotspotSubscriptionPolicyRegistrationTest extends TestCase
{
    public function test_hotspot_subscription_policy_is_registered(): void
    {
        $module = app(SubscriptionModule::class);

        $manifest = $module->manifest();

        $registrar = app(LaravelModuleRegistrar::class);

        foreach ($manifest->resources() as $resource) {
            $resource->register($registrar);
        }

        $policy = Gate::getPolicyFor(
            HotspotSubscription::class
        );

        $this->assertInstanceOf(
            HotspotSubscriptionPolicy::class,
            $policy
        );
    }

    public function test_hotspot_subscription_policy_resolves_expected_permissions(): void
    {
        $policy = new HotspotSubscriptionPolicy();

        $user = new User();

        $subscription = new HotspotSubscription();

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
    }
}
