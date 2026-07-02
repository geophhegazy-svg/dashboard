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


class SubscriptionRenewalServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_can_be_renewed(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 1000,
            'monthly_price' => 350,
            'pppoe_username' => 'test-user',
        ]);

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enablePppoe')
            ->with('test-user');

        $service = new SubscriptionRenewalService();

        $result = $service->renewPppoe($subscription, $mikrotik);

        $this->assertTrue($result);

        $subscription->refresh();

        $this->assertEquals(650, $subscription->wallet_balance);
    }

    public function test_renewal_creates_invoice(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 1000,
            'monthly_price' => 350,
            'pppoe_username' => 'test-user',
        ]);

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enablePppoe');

        $service = new SubscriptionRenewalService();

        $service->renewPppoe($subscription, $mikrotik);

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
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 1000,
            'monthly_price' => 350,
            'pppoe_username' => 'test-user',
        ]);

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enablePppoe');

        $service = new SubscriptionRenewalService();

        $service->renewPppoe($subscription, $mikrotik);

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
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 1000,
            'monthly_price' => 350,
            'pppoe_username' => 'test-user',
        ]);

        $mikrotik = $this->createMock(MikrotikServiceInterface::class);

        $mikrotik
            ->expects($this->once())
            ->method('enablePppoe');

        $service = new SubscriptionRenewalService();

        $service->renewPppoe($subscription, $mikrotik);

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
}
