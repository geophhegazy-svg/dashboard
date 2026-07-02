<?php

namespace App\Http\Requests\Subscription;

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
                'exists:tenants,id',
            ],

            'customer_id' => [
                'sometimes',
                'exists:customers,id',
            ],

            'package_id' => [
                'sometimes',
                'exists:packages,id',
            ],

            'start_date' => [
                'sometimes',
                'date',
            ],

            'end_date' => [
                'sometimes',
                'date',
                'after:start_date',
            ],

            'monthly_price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'wallet_balance' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'status' => [
                'sometimes',
                'in:active,suspended,expired',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
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

    public function messages(): array
    {
        return [

            'tenant_id.exists' => 'Selected tenant does not exist.',

            'customer_id.exists' => 'Selected customer does not exist.',

            'package_id.exists' => 'Selected package does not exist.',

            'end_date.after' => 'End date must be after start date.',

        ];
    }
}
