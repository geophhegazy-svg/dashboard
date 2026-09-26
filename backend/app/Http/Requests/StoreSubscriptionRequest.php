<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => [
                'required',
                'exists:tenants,id',
            ],

            'customer_id' => [
                'required',
                'exists:customers,id',
            ],

            'package_id' => [
                'required',
                'exists:packages,id',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'monthly_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'pending',
                    'active',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'pppoe_username' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pppoe_password' => [
                'nullable',
                'string',
                'max:255',
            ],

            'mikrotik_profile' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}