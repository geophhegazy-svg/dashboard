<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['tenant_id' => ['required', 'exists:tenants,id'], 'device_type' => ['required', 'in:onu,router,mikrotik,switch,olt'], 'brand' => ['required', 'string', 'max:255'], 'model' => ['nullable', 'string', 'max:255'], 'quantity' => ['required', 'integer', 'min:0'], 'minimum_quantity' => ['required', 'integer', 'min:0'], 'notes' => ['nullable', 'string'],];
    }
}
