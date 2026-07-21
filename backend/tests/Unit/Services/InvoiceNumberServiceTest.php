<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Invoice;
use App\Modules\Invoice\InvoiceNumberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceNumberServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_returns_invoice_number(): void
    {
        $invoice = Invoice::factory()->create();

        $number = InvoiceNumberService::generate($invoice);

        $this->assertEquals(
            'INV-' . str_pad(
                (string) $invoice->id,
                6,
                '0',
                STR_PAD_LEFT
            ),
            $number
        );
    }

    public function test_generate_returns_correct_number_for_multiple_invoices(): void
    {
        Invoice::factory()->count(3)->create();

        $invoice = Invoice::factory()->create();

        $number = InvoiceNumberService::generate($invoice);

        $this->assertEquals(
            'INV-' . str_pad(
                (string) $invoice->id,
                6,
                '0',
                STR_PAD_LEFT
            ),
            $number
        );
    }
}
