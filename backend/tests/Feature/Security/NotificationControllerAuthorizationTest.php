<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class NotificationControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate(array $permissions = []): User
    {
        $user = User::factory()->create();

        foreach ($permissions as $permission) {
            $permissionModel = Permission::findOrCreate($permission, 'web');
            $user->givePermissionTo($permissionModel);
        }

        Sanctum::actingAs($user);

        return $user;
    }

    private function createNotification(): Notification
    {
        $subscription = Subscription::factory()->create();

        return Notification::create([
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'type' => 'renewal',
            'title' => 'Renewal Reminder',
            'message' => 'Subscription renewal reminder.',
            'is_read' => false,
            'sent_at' => now(),
        ]);
    }

    public function test_index_requires_view_permission(): void
    {
        $this->authenticate();

        $this->getJson('/api/notifications')
            ->assertForbidden();
    }

    public function test_index_allows_view_permission(): void
    {
        $this->authenticate(['notifications.view']);

        $this->getJson('/api/notifications')
            ->assertOk();
    }

    public function test_show_requires_view_permission(): void
    {
        $this->authenticate();

        $notification = $this->createNotification();

        $this->getJson("/api/notifications/{$notification->id}")
            ->assertForbidden();
    }

    public function test_show_allows_view_permission(): void
    {
        $this->authenticate(['notifications.view']);

        $notification = $this->createNotification();

        $this->getJson("/api/notifications/{$notification->id}")
            ->assertOk();
    }

    public function test_mark_as_read_requires_read_permission(): void
    {
        $this->authenticate();

        $notification = $this->createNotification();

        $this->postJson("/api/notifications/{$notification->id}/read")
            ->assertForbidden();
    }

    public function test_mark_as_read_allows_read_permission(): void
    {
        $this->authenticate(['notifications.read']);

        $notification = $this->createNotification();

        $this->postJson("/api/notifications/{$notification->id}/read")
            ->assertOk();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'is_read' => true,
        ]);
    }

    public function test_mark_all_as_read_requires_read_permission(): void
    {
        $this->authenticate();

        $this->createNotification();

        $this->postJson('/api/notifications/read-all')
            ->assertForbidden();
    }

    public function test_mark_all_as_read_allows_read_permission(): void
    {
        $this->authenticate(['notifications.read']);

        $notification = $this->createNotification();

        $this->postJson('/api/notifications/read-all')
            ->assertOk();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'is_read' => true,
        ]);
    }

    public function test_delete_requires_delete_permission(): void
    {
        $this->authenticate();

        $notification = $this->createNotification();

        $this->deleteJson("/api/notifications/{$notification->id}")
            ->assertForbidden();
    }

    public function test_delete_allows_delete_permission(): void
    {
        $this->authenticate(['notifications.delete']);

        $notification = $this->createNotification();

        $this->deleteJson("/api/notifications/{$notification->id}")
            ->assertOk();

        $this->assertDatabaseMissing('notifications', [
            'id' => $notification->id,
        ]);
    }
}
