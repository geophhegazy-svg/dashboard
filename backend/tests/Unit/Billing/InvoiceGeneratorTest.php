<?php

declare(strict_types=1);

namespace Tests\Unit\Billing;

use App\Modules\Billing\Application\Services\InvoiceGenerator;
use App\Modules\Billing\Application\Workflows\GenerateInvoiceWorkflow;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Mockery;
use Tests\TestCase;

class InvoiceGeneratorTest extends TestCase
{
    public function test_it_generates_invoice_through_invoice_service(): void
    {
        $package = new Package([
            'price' => 725,
        ]);

        $subscription = new Subscription([
            'tenant_id' => 11,
            'customer_id' => 22,
            'package_id' => 33,
        ]);

        $subscription->id = 33;

        $subscription->setRelation('package', $package);

        $invoice = new Invoice([
            'tenant_id' => 11,
            'customer_id' => 22,
            'subscription_id' => 33,
            'amount' => 725,
            'status' => 'pending',
        ]);

        $invoiceService = Mockery::mock(InvoiceServiceInterface::class);

        $invoiceService
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function (array $data): bool {
                return $data['tenant_id'] === 11
                    && $data['customer_id'] === 22
                    && $data['subscription_id'] === 33
                    && $data['amount'] === 725
                    && $data['status'] === 'pending'
                    && isset($data['due_date'])
                    && is_string($data['due_date']);
            }))
            ->andReturn($invoice);

        $workflow = new GenerateInvoiceWorkflow(
            $invoiceService
        );

        $generator = new InvoiceGenerator(
            $workflow
        );

        $result = $generator->generate(
            $subscription
        );

        $this->assertSame(
            $invoice,
            $result
        );
    }
}
