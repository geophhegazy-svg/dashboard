<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduledReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'report_name' => [
                'required',
                'string',
                'max:255',
            ],

            'format' => [
                'required',
                Rule::in([
                    'csv',
                    'xlsx',
                ]),
            ],

            'filters' => [
                'nullable',
                'array',
            ],

            'frequency' => [
                'required',
                Rule::in([
                    'daily',
                    'weekly',
                    'monthly',
                    'yearly',
                ]),
            ],

            'is_active' => [
                'boolean',
            ],
        ];
    }
}
