<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['tenant_id' => ['required', 'exists:tenants,id'], 'invoice_id' => ['required', 'exists:invoices,id'], 'amount' => ['required', 'numeric', 'min:0'], 'payment_date' => ['required', 'date'], 'payment_method' => ['required', 'in:cash,bank_transfer,vodafone_cash,instapay,card'], 'reference_number' => ['nullable', 'string', 'max:255'], 'notes' => ['nullable', 'string'],];
    }
}
