<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduledReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_name' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'frequency' => [
                'sometimes',
                'in:daily,weekly,monthly',
            ],

            'format' => [
                'sometimes',
                'in:csv,xlsx,pdf',
            ],

            'email' => [
                'sometimes',
                'email',
            ],

            'enabled' => [
                'boolean',
            ],
        ];
    }
}
