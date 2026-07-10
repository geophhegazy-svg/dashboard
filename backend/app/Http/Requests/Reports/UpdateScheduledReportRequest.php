<?php

declare(strict_types=1);

namespace App\Http\Requests\Reports;

class UpdateScheduledReportRequest extends StoreScheduledReportRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        foreach ($rules as $field => $rule) {
            array_unshift($rules[$field], 'sometimes');
        }

        return $rules;
    }
}
