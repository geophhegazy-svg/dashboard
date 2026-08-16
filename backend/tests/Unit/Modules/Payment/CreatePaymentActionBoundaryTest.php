<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Payment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Payment\Application\Actions\CreatePaymentAction;

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
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 100,
        ]);

        $invoice = Invoice::factory()->create([
            'subscription_id' => $subscription->id,
            'amount' => 500,
            'status' => 'pending',
        ]);

        app(CreatePaymentAction::class)->execute([
            'invoice_id' => $invoice->id,
            'amount' => 550,
            'payment_method' => 'cash',
        ]);

        $subscription->refresh();

        $this->assertEquals(
            150,
            (float) $subscription->wallet_balance,
        );

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid',
        ]);
    }
}
