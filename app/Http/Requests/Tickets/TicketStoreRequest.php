<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
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
        'customer_id' => 'nullable|exists:customers,id',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'status' => 'nullable|in:new,in_progress,processed',
        'answered_at' => 'nullable|date',
        'files.*' => 'file|max:10240',
        ];
    }


}
