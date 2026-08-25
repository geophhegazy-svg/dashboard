<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerInvoiceResource;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\FindCustomerInvoiceQuery;
use App\Modules\Invoice\Application\Queries\PaginateCustomerInvoicesQuery;
use Illuminate\Http\Request;

class CustomerInvoiceController extends Controller
{
    public function __construct(
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index(Request $request)
    {
        $customer = $request->user();

        $invoices = $this->queryDispatcher->dispatch(
            new PaginateCustomerInvoicesQuery(
                customerId: (int) $customer->id,
                perPage: 10,
            )
        );

        return CustomerInvoiceResource::collection($invoices);
    }

    public function show(Request $request, int $invoice)
    {
        $customer = $request->user();

        $invoiceModel = $this->queryDispatcher->dispatch(
            new FindCustomerInvoiceQuery(
                customerId: (int) $customer->id,
                invoiceId: $invoice,
            )
        );

        abort_if($invoiceModel === null, 404);

        return new CustomerInvoiceResource($invoiceModel);
    }
}
