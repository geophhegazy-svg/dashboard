<?php

declare(strict_types=1);

namespace App\Http\Requests\ScheduledReport;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduledReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => ['required', 'string', 'max:255'],

            'report_name' => ['required', 'string', 'max:255'],

            'frequency' => [
                'required',
                'in:hourly,daily,weekly,monthly'
            ],

            'format' => [
                'required',
                'in:csv,xlsx'
            ],

            'filters' => ['nullable', 'array'],

            'email' => ['nullable', 'email'],

            'is_active' => ['sometimes', 'boolean'],

            'next_run_at' => ['nullable', 'date'],

            'created_by' => [
                'nullable',
                'exists:users,id'
            ],
        ];
    }
}
