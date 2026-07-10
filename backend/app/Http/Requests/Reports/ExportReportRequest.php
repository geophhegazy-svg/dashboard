<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportReportRequest extends FormRequest
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
            'format' => [
                'required',
                'string',
                Rule::in([
                    'csv',
                    'xlsx',
                ]),
            ],

            'filters' => [
                'nullable',
                'array',
            ],
        ];
    }

    public function format(): string
    {
        return $this->validated('format');
    }

    /**
     * @return array<string, mixed>
     */
    public function filters(): array
    {
        return $this->validated('filters', []);
    }
}
