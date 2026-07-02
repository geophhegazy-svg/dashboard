<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class RenewSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'months' => [
                'sometimes',
                'integer',
                'min:1',
                'max:24',
            ],

            'payment_method' => [
                'nullable',
                'string',
                'max:50',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'months.integer' => 'Months must be an integer.',

            'months.min' => 'Minimum renewal period is one month.',

            'months.max' => 'Maximum renewal period is 24 months.',

        ];
    }
}
