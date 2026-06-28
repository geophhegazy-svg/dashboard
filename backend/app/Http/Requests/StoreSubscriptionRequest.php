<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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

            'tenant_id' => [
                'required',
                'exists:tenants,id'
            ],

            'customer_id' => [
                'required',
                'exists:customers,id'
            ],

            'package_id' => [
                'required',
                'exists:packages,id'
            ],

            'start_date' => [
                'required',
                'date'
            ],

            'end_date' => [
                'nullable',
                'date'
            ],

            'monthly_price' => [
                'required',
                'numeric'
            ],

            'status' => [
                'required',
                'in:active,expired,suspended'
            ],

            'notes' => [
                'nullable',
                'string'
            ],
        ];
    }
}
