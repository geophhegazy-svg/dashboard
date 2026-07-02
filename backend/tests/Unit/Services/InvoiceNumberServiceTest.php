<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Invoice;
use App\Services\InvoiceNumberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceNumberServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_returns_first_invoice_number(): void
    {
        $number = InvoiceNumberService::generate();

        $this->assertEquals(
            'INV-000001',
            $number
        );
    }

    public function test_generate_returns_next_invoice_number(): void
    {
        $invoice = Invoice::factory()->create();

        $number = InvoiceNumberService::generate();

        $expected = 'INV-' . str_pad(
            (string) ($invoice->id + 1),
            6,
            '0',
            STR_PAD_LEFT
        );

        $this->assertEquals(
            $expected,
            $number
        );
    }
}
