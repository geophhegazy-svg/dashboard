<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => [
                'sometimes',
                'required',
                'exists:tenants,id',
            ],

            'customer_id' => [
                'sometimes',
                'required',
                'exists:customers,id',
            ],

            'package_id' => [
                'sometimes',
                'required',
                'exists:packages,id',
            ],

            'start_date' => [
                'sometimes',
                'required',
                'date',
            ],

            'end_date' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'monthly_price' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'prohibited',
            ],

            'notes' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'pppoe_username' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'pppoe_password' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'mikrotik_profile' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}