<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Automation\Actions\GenerateInvoicesAction;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Mockery;
use Tests\TestCase;

class GenerateInvoicesActionTest extends TestCase
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

        $subscription->setRelation(
            'package',
            $package,
        );

        $invoice = new Invoice([
            'tenant_id' => 11,
            'customer_id' => 22,
            'subscription_id' => 33,
            'amount' => 725,
            'status' => 'pending',
        ]);

        $invoiceService = Mockery::mock(
            InvoiceServiceInterface::class,
        );

        $invoiceService
            ->shouldReceive('create')
            ->once()
            ->with([
                'tenant_id' => 11,
                'customer_id' => 22,
                'subscription_id' => 33,
                'amount' => 725,
                'due_date' => now()->toDateString(),
                'status' => 'pending',
            ])
            ->andReturn($invoice);

        $action = new GenerateInvoicesAction(
            $invoiceService,
        );

        $action->execute($subscription);
    }
}
