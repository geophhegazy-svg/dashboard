<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Subscription\Listeners;

use Tests\TestCase;
use Mockery;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;

class SubscriptionRenewedListenerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $mikrotik = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotik
            ->shouldReceive('enableUser')
            ->zeroOrMoreTimes()
            ->andReturnTrue();

        $this->app->instance(
            MikrotikServiceInterface::class,
            $mikrotik
        );
    }

    private function subscription(): Subscription
    {
        return Subscription::factory()->create([
            'monthly_price' => 350,
        ]);
    }

    public function test_listener_creates_invoice(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-001'
        );

        $this->assertDatabaseHas('invoices', [
            'subscription_id' => $subscription->id,
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'renewal_key'     => 'renewal-test-001',
            'amount'          => 350,
            'status'          => 'pending',
        ]);
    }

    public function test_listener_creates_notification(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-001'
        );

        $this->assertDatabaseHas('notifications', [
            'tenant_id'   => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'type'        => 'subscription_renewed',
        ]);
    }

    public function test_listener_creates_activity_log(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-001'
        );

        $this->assertDatabaseHas('activity_logs', [
            'tenant_id' => $subscription->tenant_id,
            'module'    => 'subscription',
            'action'    => 'renewed',
        ]);
    }

    public function test_listener_creates_a_new_invoice_for_a_new_renewal(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-001'
        );

        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-002'
        );

        $this->assertCount(
            2,
            Invoice::where(
                'subscription_id',
                $subscription->id
            )->get()
        );

        $this->assertDatabaseHas('invoices', [
            'subscription_id' => $subscription->id,
            'renewal_key'     => 'renewal-test-001',
        ]);

        $this->assertDatabaseHas('invoices', [
            'subscription_id' => $subscription->id,
            'renewal_key'     => 'renewal-test-002',
        ]);
    }

    public function test_listener_is_idempotent(): void
    {
        $subscription = $this->subscription();

        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-001'
        );
        SubscriptionRenewed::dispatch(
            $subscription,
            'renewal-test-001'
        );

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
