<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Subscription\Listeners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Models\Notification;
use App\Models\ActivityLog;

class SubscriptionRenewedListenerTest extends TestCase
{
    use RefreshDatabase;

    private function subscription(): Subscription
    {
        return Subscription::factory()->create([
            'wallet_balance' => 1000,
            'monthly_price'  => 350,
        ]);
    }

    public function test_listener_creates_invoice(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch($subscription);

        $this->assertDatabaseHas('invoices', [
            'subscription_id' => $subscription->id,
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'amount'          => 350,
            'status'          => 'pending',
        ]);
    }

    public function test_listener_creates_notification(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch($subscription);

        $this->assertDatabaseHas('notifications', [
            'tenant_id'   => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'type'        => 'subscription_renewed',
        ]);
    }

    public function test_listener_creates_activity_log(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch($subscription);

        $this->assertDatabaseHas('activity_logs', [
            'tenant_id' => $subscription->tenant_id,
            'module'    => 'subscription',
            'action'    => 'renewed',
        ]);
    }

    public function test_listener_is_idempotent(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch($subscription);
        SubscriptionRenewed::dispatch($subscription);

        $this->assertCount(
            1,
            Invoice::where(
                'subscription_id',
                $subscription->id
            )->get()
        );

        $this->assertCount(
            1,
            Notification::where(
                'customer_id',
                $subscription->customer_id
            )->get()
        );

        $this->assertCount(
            1,
            ActivityLog::where(
                'tenant_id',
                $subscription->tenant_id
            )->where(
                'action',
                'renewed'
            )->get()
        );
    }
}
