<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceService;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Invoice::class);

        return InvoiceResource::collection(
            Invoice::with([
                'customer',
                'subscription',
            ])->latest()->paginate()
        );
    }

    public function store(StoreInvoiceRequest $request)
    {
        $this->authorize('create', Invoice::class);

        $invoice = $this->invoiceService->create(
            $request->validated()
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

        $invoice = $this->invoiceService->update(
            $invoice,
            $request->validated()
        );

        return new InvoiceResource($invoice);
    }

    public function destroy(
        Invoice $invoice
    ) {
        $this->authorize('delete', $invoice);

        $this->invoiceService->delete($invoice);

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ]);
    }
}
