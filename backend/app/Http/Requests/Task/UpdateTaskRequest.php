<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'priority' => ['sometimes', 'in:low,medium,high,critical'],
            'status' => ['sometimes', 'in:pending,in_progress,completed,cancelled'],
            'meta' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
