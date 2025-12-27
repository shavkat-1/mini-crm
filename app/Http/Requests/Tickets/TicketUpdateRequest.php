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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'customer_id' => 'sometimes|exists:customers,id',
        'subject' => 'sometimes|string|max:255',
        'message' => 'sometimes|string',
        'status' => 'sometimes|in:new,in_progress,processed',
        'answered_at' => 'sometimes|date',
        'files.*' => 'sometimes|max:10240',
    ];
}

}
