<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['tenant_id' => ['required', 'exists:tenants,id'], 'customer_id' => ['required', 'exists:customers,id'], 'device_id' => ['required', 'exists:devices,id'], 'assigned_at' => ['required', 'date'], 'returned_at' => ['nullable', 'date'], 'status' => ['required', 'in:assigned,returned,lost,damaged'], 'notes' => ['nullable', 'string'],];
    }
}
