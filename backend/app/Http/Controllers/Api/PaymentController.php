<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Modules\Payment\PaymentService;


class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService
    ) {}
    public function index()
    {
        $this->authorize('viewAny', Payment::class);
        return PaymentResource::collection(Payment::latest()->paginate());
    }
    public function store(StorePaymentRequest $request)
    {
        $this->authorize('create', Payment::class);

        $payment = $this->paymentService->create(
            $request->validated()
        );

        return new PaymentResource($payment);
    }
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);
        return new PaymentResource($payment);
    }
    public function update(StorePaymentRequest $request, Payment $payment)
    {
        $this->authorize('update', $payment);
        $payment->update($request->validated());
        return new PaymentResource($payment);
    }
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
