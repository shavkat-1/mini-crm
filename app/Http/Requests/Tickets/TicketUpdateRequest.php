<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'sometimes|required|exists:customers,id',
            'subject' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'status' => 'sometimes|in:new,in_progress,processed',
            'answered_at' => 'sometimes|nullable|date',
        ];
    }
}
