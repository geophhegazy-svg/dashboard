<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\PaginateInvoicesQuery;
use App\Core\CommandBus\CommandDispatcher;

use App\Modules\Invoice\Application\Commands\CreateInvoiceCommand;
use App\Modules\Invoice\Application\Commands\UpdateInvoiceCommand;
use App\Modules\Invoice\Application\Commands\DeleteInvoiceCommand;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly CommandDispatcher $commandDispatcher,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Invoice::class);

        return InvoiceResource::collection(
            $this->queryDispatcher->dispatch(
                new PaginateInvoicesQuery()
            )
        );
    }

    public function store(StoreInvoiceRequest $request)
    {
        $this->authorize('create', Invoice::class);

        $invoice = $this->commandDispatcher->dispatch(
            new CreateInvoiceCommand(
                $request->validated()
            )
        );

        return new InvoiceResource(
            $invoice->load([
                'customer',
                'subscription',
            ])
        );
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        return new InvoiceResource(
            $invoice->load([
                'customer',
                'subscription',
            ])
        );
    }

    public function update(
        StoreInvoiceRequest $request,
        Invoice $invoice
    ) {
        $this->authorize('update', $invoice);

        $invoice = $this->commandDispatcher->dispatch(
            new UpdateInvoiceCommand(
                $invoice,
                $request->validated()
            )
        );

        return new InvoiceResource($invoice);
    }

    public function destroy(
        Invoice $invoice
    ) {
        $this->authorize('delete', $invoice);

        $this->commandDispatcher->dispatch(
            new DeleteInvoiceCommand(
                $invoice
            )
        );

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ]);
    }
}
