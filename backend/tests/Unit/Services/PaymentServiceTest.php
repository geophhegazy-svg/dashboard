<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_can_be_created(): void
    {
        $invoice = Invoice::factory()->create([
            'amount' => 500,
            'status' => 'pending',
        ]);

        $service = app(PaymentService::class);

        $payment = $service->create([
            'invoice_id' => $invoice->id,
            'amount' => 300,
            'payment_method' => 'cash',
        ]);

        $this->assertInstanceOf(
            Payment::class,
            $payment
        );

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount' => 300,
        ]);
    }
}
