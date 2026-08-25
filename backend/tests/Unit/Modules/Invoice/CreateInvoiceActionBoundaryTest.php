<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoice;

use App\Modules\Invoice\Application\Actions\CreateInvoiceAction;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateInvoiceActionBoundaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_number_is_generated_by_the_invoice_creation_action(): void
    {
        $repository = app(InvoiceRepositoryInterface::class);

        $action = new CreateInvoiceAction($repository);

        $subscription = \App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription::factory()
            ->create();

        $invoice = $action->execute([
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'amount' => 100,
            'due_date' => now()->addDays(7),
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertNotNull($invoice->invoice_number);
        $this->assertNotSame('', $invoice->invoice_number);
    }
}
