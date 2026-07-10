<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $reportId = $this->route('report');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('reports', 'name')->ignore($reportId),
            ],

            'title' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'type' => [
                'sometimes',
                'string',
                'max:50',
            ],

            'enabled' => [
                'boolean',
            ],
        ];
    }
}
