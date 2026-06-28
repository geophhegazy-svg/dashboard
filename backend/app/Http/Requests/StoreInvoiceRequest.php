<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['tenant_id' => ['required', 'exists:tenants,id'], 'customer_id' => ['required', 'exists:customers,id'], 'subscription_id' => ['required', 'exists:subscriptions,id'], 'invoice_number' => ['required', 'string', 'max:100', 'unique:invoices,invoice_number'], 'amount' => ['required', 'numeric', 'min:0'], 'due_date' => ['required', 'date'], 'paid_at' => ['nullable', 'date'], 'status' => ['required', 'in:pending,paid,overdue,cancelled'], 'notes' => ['nullable', 'string'],];
    }
}
