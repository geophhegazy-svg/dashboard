<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Payment;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Payment\Application\Actions\CreatePaymentAction;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreatePaymentActionBoundaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_payment_settles_invoice(): void
    {
        $invoice = Invoice::factory()->create([
            'amount' => 500,
            'status' => 'pending',
        ]);

        $payment = app(CreatePaymentAction::class)->execute([
            'invoice_id' => $invoice->id,
            'amount' => 500,
            'payment_method' => 'cash',
        ]);

        $this->assertInstanceOf(
            Payment::class,
            $payment,
        );

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid',
        ]);
    }

    public function test_overpayment_is_delegated_to_wallet_service(): void
    {
        $customer = Customer::factory()->create();

        $subscription = Subscription::factory()->create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
        ]);

        $wallet = Wallet::create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'balance' => 100,
        ]);

        $invoice = Invoice::factory()->create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'subscription_id' => $subscription->id,
            'amount' => 500,
            'status' => 'pending',
        ]);

        app(CreatePaymentAction::class)->execute([
            'invoice_id' => $invoice->id,
            'amount' => 550,
            'payment_method' => 'cash',
        ]);

        $wallet->refresh();

        $this->assertEquals(
            150,
            (float) $wallet->balance,
        );

        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'amount' => 50,
            'type' => 'deposit',
            'description' => 'Invoice overpayment credit',
            'reference' => $invoice->invoice_number,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid',
        ]);

        $this->assertDatabaseMissing('wallets', [
            'customer_id' => $subscription->id,
            'balance' => 150,
        ]);
    }
}
