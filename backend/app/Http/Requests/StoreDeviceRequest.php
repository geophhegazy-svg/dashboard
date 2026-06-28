<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['tenant_id' => ['required', 'exists:tenants,id'], 'customer_id' => ['nullable', 'exists:customers,id'], 'device_type' => ['required', 'in:onu,router,mikrotik,switch,olt'], 'brand' => ['required', 'string', 'max:255'], 'model' => ['nullable', 'string', 'max:255'], 'serial_number' => ['nullable', 'string', 'max:255'], 'mac_address' => ['nullable', 'string', 'max:255'], 'ip_address' => ['nullable', 'ip'], 'status' => ['required', 'in:active,inactive,faulty,returned'], 'notes' => ['nullable', 'string'],];
    }
}
