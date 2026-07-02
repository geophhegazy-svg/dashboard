<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;

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
                'required',
                'date',
                'after:start_date',
            ],

            'monthly_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'wallet_balance' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
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

            'tenant_id.required' => 'Tenant is required.',
            'tenant_id.exists' => 'Selected tenant does not exist.',

            'customer_id.required' => 'Customer is required.',
            'customer_id.exists' => 'Selected customer does not exist.',

            'package_id.required' => 'Package is required.',
            'package_id.exists' => 'Selected package does not exist.',

            'end_date.after' => 'End date must be after start date.',

        ];
    }
}
