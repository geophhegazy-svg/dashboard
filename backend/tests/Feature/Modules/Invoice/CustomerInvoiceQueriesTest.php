<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Invoice;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Invoice\Application\Queries\FindCustomerInvoiceQuery;
use App\Modules\Invoice\Application\Queries\PaginateCustomerInvoicesQuery;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CustomerInvoiceQueriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_invoice_pagination_is_scoped_to_customer(): void
    {
        $customerA = Customer::factory()->create();
        $customerB = Customer::factory()->create();

        Invoice::factory()
            ->count(2)
            ->create([
                'customer_id' => $customerA->id,
            ]);

        Invoice::factory()
            ->count(3)
            ->create([
                'customer_id' => $customerB->id,
            ]);

        $result = $this->app
            ->make(QueryDispatcher::class)
            ->dispatch(
                new PaginateCustomerInvoicesQuery(
                    customerId: (int) $customerA->id,
                    perPage: 10,
                )
            );

        $this->assertCount(2, $result->items());

        foreach ($result->items() as $invoice) {
            $this->assertSame(
                $customerA->id,
                $invoice->customer_id,
            );
        }
    }

    public function test_customer_can_find_only_own_invoice(): void
    {
        $customerA = Customer::factory()->create();
        $customerB = Customer::factory()->create();

        $ownInvoice = Invoice::factory()->create([
            'customer_id' => $customerA->id,
        ]);

        $otherInvoice = Invoice::factory()->create([
            'customer_id' => $customerB->id,
        ]);

        $dispatcher = $this->app->make(QueryDispatcher::class);

        $result = $dispatcher->dispatch(
            new FindCustomerInvoiceQuery(
                customerId: (int) $customerA->id,
                invoiceId: (int) $ownInvoice->id,
            )
        );

        $this->assertNotNull($result);
        $this->assertSame(
            $ownInvoice->id,
            $result->id,
        );

        $result = $dispatcher->dispatch(
            new FindCustomerInvoiceQuery(
                customerId: (int) $customerA->id,
                invoiceId: (int) $otherInvoice->id,
            )
        );

        $this->assertNull($result);
    }
}
