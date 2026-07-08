<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\MikrotikServiceInterface;
use App\Models\Subscription;
use App\Services\SubscriptionRenewalService;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\ActivityLog;


class SubscriptionRenewalServiceTest extends TestCase
{
    use RefreshDatabase;

    private function createSubscription(): Subscription
    {
        return Subscription::factory()->create([
            'wallet_balance' => 1000,
            'monthly_price' => 350,
            'pppoe_username' => 'test-user',
        ]);
    }

    public function test_subscription_can_be_renewed(): void
    {
        $subscription = $this->createSubscription();

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enableUser')
            ->with('test-user');

        $service = new SubscriptionRenewalService($mikrotik);

        $result = $service->renewPppoe($subscription);

        $this->assertTrue($result);

        $subscription->refresh();

        $this->assertEquals(650, $subscription->wallet_balance);
    }

    public function test_renewal_creates_invoice(): void
    {
        $subscription = $this->createSubscription();

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enableUser');

        $service = new SubscriptionRenewalService($mikrotik);

        $service->renewPppoe($subscription);

        $this->assertDatabaseHas('invoices', [
            'subscription_id' => $subscription->id,
            'customer_id'     => $subscription->customer_id,
            'tenant_id'       => $subscription->tenant_id,
            'amount'          => 350,
            'status'          => 'paid',
        ]);

        $invoice = Invoice::where('subscription_id', $subscription->id)->first();

        $this->assertNotNull($invoice);
        $this->assertNotNull($invoice->paid_at);
    }

    public function test_renewal_creates_payment(): void
    {
        $subscription = $this->createSubscription();

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enableUser');

        $service = new SubscriptionRenewalService($mikrotik);

        $service->renewPppoe($subscription);

        $invoice = Invoice::where('subscription_id', $subscription->id)->first();

        $this->assertNotNull($invoice);

        $this->assertDatabaseHas('payments', [
            'invoice_id'       => $invoice->id,
            'tenant_id'        => $subscription->tenant_id,
            'amount'           => 350,
            'payment_method'   => 'wallet',
            'reference_number' => 'AUTO-WALLET',
        ]);

        $payment = Payment::where('invoice_id', $invoice->id)->first();

        $this->assertNotNull($payment);
        $this->assertEquals(350, $payment->amount);
    }

    public function test_renewal_creates_notification(): void
    {
        $subscription = $this->createSubscription();

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enableUser');

        $service = new SubscriptionRenewalService($mikrotik);

        $service->renewPppoe($subscription);

        $this->assertDatabaseHas('notifications', [
            'tenant_id'   => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'type'        => 'subscription_renewed',
            'title'       => 'تم تجديد الاشتراك',
        ]);

        $notification = Notification::where('customer_id', $subscription->customer_id)->first();

        $this->assertNotNull($notification);
        $this->assertStringContainsString(
            (string) $subscription->monthly_price,
            $notification->message
        );
    }

    public function test_renewal_creates_activity_log(): void
    {
        $subscription = $this->createSubscription();

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enableUser');

        $service = new SubscriptionRenewalService($mikrotik);

        $service->renewPppoe($subscription);

        $this->assertDatabaseHas('activity_logs', [
            'tenant_id'   => $subscription->tenant_id,
            'module'      => 'subscription',
            'action'      => 'renewed',
        ]);

        $log = ActivityLog::where('tenant_id', $subscription->tenant_id)
            ->latest()
            ->first();

        $this->assertNotNull($log);

        $this->assertStringContainsString(
            (string) $subscription->id,
            $log->description
        );
    }
}
