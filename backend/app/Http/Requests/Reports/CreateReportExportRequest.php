<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class CreateReportExportRequest extends FormRequest
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

            'format' => [
                'required',
                'in:csv,xlsx,pdf',
            ],
        ];
    }
}
