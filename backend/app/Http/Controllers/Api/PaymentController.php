<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\Invoice;

class PaymentController extends Controller
{
    public function index()
    {
        return PaymentResource::collection(Payment::latest()->paginate());
    }
    public function store(StorePaymentRequest $request)
    {
        $invoice = \App\Models\Invoice::findOrFail(
            $request->invoice_id
        );

        if ($invoice->status === 'paid') {

            return response()->json([
                'message' => 'Invoice already paid'
            ], 422);
        }
        $invoice = Invoice::findOrFail(
            $request->invoice_id
        );
        $payment = Payment::create(
            $request->validated()
        );

        if ($invoice->status === 'paid') {

            return response()->json([
                'message' => 'Invoice already paid'
            ], 422);
        }

        $totalPaidBefore = $invoice->payments()->sum('amount');

        $remaining =
            $invoice->amount - $totalPaidBefore;

        $payment = Payment::create(
            $request->validated()
        );

        $totalPaidAfter =
            $totalPaidBefore + $payment->amount;

        if ($totalPaidAfter >= $invoice->amount) {

            $invoice->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $extraCredit =
                max(
                    0,
                    $totalPaidAfter - $invoice->amount
                );

            if ($extraCredit > 0) {

                if ($invoice->subscription) {

                    $invoice->subscription->increment(
                        'wallet_balance',
                        $extraCredit
                    );
                }

                if ($invoice->hotspotSubscription) {

                    $invoice->hotspotSubscription->increment(
                        'wallet_balance',
                        $extraCredit
                    );
                }
            }
        }
        return new PaymentResource($payment);
    }
    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }
    public function update(StorePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return new PaymentResource($payment);
    }
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
