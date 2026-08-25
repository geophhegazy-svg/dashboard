<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\FindCustomerInvoiceQuery;
use App\Modules\Invoice\Application\Queries\PaginateCustomerInvoicesQuery;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
{
    public function __construct(
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $invoices = $this->queryDispatcher->dispatch(
            new PaginateCustomerInvoicesQuery(
                customerId: (int) $customer->id,
                perPage: 10,
            )
        );

        return view(
            'customer.invoices',
            compact('invoices')
        );
    }

    public function show(int $id)
    {
        $customer = Auth::guard('customer')->user();

        $invoice = $this->queryDispatcher->dispatch(
            new FindCustomerInvoiceQuery(
                customerId: (int) $customer->id,
                invoiceId: $id,
            )
        );

        abort_if($invoice === null, 404);

        return view(
            'customer.invoice-detail',
            compact('invoice')
        );
    }
}
