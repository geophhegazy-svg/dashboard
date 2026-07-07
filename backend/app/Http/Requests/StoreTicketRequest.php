<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['customer_id' => ['required', 'exists:customers,id'], 'user_id' => ['nullable', 'exists:users,id'], 'ticket_number' => ['required', 'string', 'max:50', 'unique:tickets,ticket_number'], 'subject' => ['required', 'string', 'max:255'], 'description' => ['required', 'string'], 'priority' => ['required', 'in:low,medium,high,critical'], 'status' => ['required', 'in:open,in_progress,resolved,closed'], 'opened_at' => ['nullable', 'date'], 'closed_at' => ['nullable', 'date'], 'notes' => ['nullable', 'string'],];
    }
}
