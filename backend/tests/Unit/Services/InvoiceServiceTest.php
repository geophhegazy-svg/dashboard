<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_can_be_created(): void
    {
        $service = app(InvoiceService::class);

        $invoice = $service->create(
            Invoice::factory()->make()->toArray()
        );

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
        ]);
    }

    public function test_invoice_can_be_updated(): void
    {
        $invoice = Invoice::factory()->create([
            'amount' => 500,
        ]);

        $service = app(InvoiceService::class);

        $updated = $service->update($invoice, [
            'amount' => 700,
        ]);

        $this->assertEquals(
            700,
            $updated->amount
        );

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'amount' => 700,
        ]);
    }

    public function test_invoice_can_be_deleted(): void
    {
        $invoice = Invoice::factory()->create();

        $service = app(InvoiceService::class);

        $service->delete($invoice);

        $this->assertDatabaseMissing('invoices', [
            'id' => $invoice->id,
        ]);
    }
}
