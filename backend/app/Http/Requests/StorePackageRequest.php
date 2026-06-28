<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id'       => ['required', 'exists:tenants,id'],
            'name'            => ['required', 'string', 'max:255'],
            'download_speed'  => ['required', 'integer', 'min:1'],
            'upload_speed'    => ['nullable', 'integer', 'min:0'],
            'price'           => ['required', 'numeric'],
            'quota_gb'        => ['nullable', 'integer'],
            'status'          => ['required', 'in:active,inactive'],
            'description'     => ['nullable', 'string'],
        ];
    }
}