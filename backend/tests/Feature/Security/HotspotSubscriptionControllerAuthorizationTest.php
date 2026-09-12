<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HotspotSubscriptionControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsUnauthorizedUser(): void
    {
        $actor = User::factory()->create();

        $this->actingAs($actor, 'sanctum');
    }

    public function test_hotspot_subscription_index_requires_view_permission(): void
    {
        $this->actingAsUnauthorizedUser();

        $this->getJson('/api/hotspot-subscriptions')
            ->assertForbidden();
    }

    public function test_hotspot_subscription_store_requires_create_permission(): void
    {
        $this->actingAsUnauthorizedUser();

        $this->postJson('/api/hotspot-subscriptions', [])
            ->assertForbidden();
    }

    public function test_hotspot_subscription_show_requires_view_permission(): void
    {
        $subscription = HotspotSubscription::factory()->create();

        $this->actingAsUnauthorizedUser();

        $this->getJson(
            "/api/hotspot-subscriptions/{$subscription->id}"
        )->assertForbidden();
    }

    public function test_hotspot_subscription_delete_requires_delete_permission(): void
    {
        $subscription = HotspotSubscription::factory()->create();

        $this->actingAsUnauthorizedUser();

        $this->deleteJson(
            "/api/hotspot-subscriptions/{$subscription->id}"
        )->assertForbidden();
    }

    public function test_hotspot_subscription_suspend_requires_suspend_permission(): void
    {
        $subscription = HotspotSubscription::factory()->create();

        $this->actingAsUnauthorizedUser();

        $this->postJson(
            "/api/hotspot-subscriptions/{$subscription->id}/suspend"
        )->assertForbidden();
    }

    public function test_hotspot_subscription_activate_requires_activate_permission(): void
    {
        $subscription = HotspotSubscription::factory()->create();

        $this->actingAsUnauthorizedUser();

        $this->postJson(
            "/api/hotspot-subscriptions/{$subscription->id}/activate"
        )->assertForbidden();
    }
}
