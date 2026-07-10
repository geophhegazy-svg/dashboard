<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduledReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_name' => [
                'required',
                'string',
                'max:100',
            ],

            'frequency' => [
                'required',
                'in:daily,weekly,monthly',
            ],

            'format' => [
                'required',
                'in:csv,xlsx,pdf',
            ],

            'email' => [
                'required',
                'email',
            ],

            'enabled' => [
                'boolean',
            ],
        ];
    }
}
