<?php

declare(strict_types=1);

namespace Tests\Unit\Billing;

use App\Modules\Billing\Application\Workflows\GenerateInvoiceWorkflow;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Mockery;
use Tests\TestCase;

class GenerateInvoiceWorkflowTest extends TestCase
{
    public function test_it_delegates_invoice_creation_to_invoice_service(): void
    {
        $package = new Package([
            'price' => 500,
        ]);

        $subscription = new Subscription([
            'tenant_id' => 10,
            'customer_id' => 20,
            'package_id' => 30,
        ]);

        $subscription->id = 30;

        $subscription->setRelation(
            'package',
            $package
        );

        $invoice = new Invoice([
            'tenant_id' => 10,
            'customer_id' => 20,
            'subscription_id' => 30,
            'amount' => 500,
            'status' => 'pending',
        ]);

        $invoiceService = Mockery::mock(
            InvoiceServiceInterface::class
        );

        $invoiceService
            ->shouldReceive('create')
            ->once()
            ->with([
                'tenant_id' => 10,
                'customer_id' => 20,
                'subscription_id' => 30,
                'amount' => 500,
                'due_date' => now()->toDateString(),
                'status' => 'pending',
            ])
            ->andReturn($invoice);

        $workflow = new GenerateInvoiceWorkflow(
            $invoiceService
        );

        $result = $workflow->execute(
            $subscription
        );

        $this->assertSame(
            $invoice,
            $result
        );
    }
}
