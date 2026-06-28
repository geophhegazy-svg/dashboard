<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['name' => ['sometimes', 'string', 'max:255'], 'email' => ['nullable', 'email'], 'phone' => ['nullable', 'string', 'max:50'], 'address' => ['nullable', 'string'], 'domain' => ['nullable', 'string', 'max:255'], 'status' => ['nullable', 'in:active,inactive'],];
    }
}
