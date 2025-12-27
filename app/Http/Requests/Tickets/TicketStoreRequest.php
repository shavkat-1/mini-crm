<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        'customer_id' => [
                'required',
                'exists:customers,id',

                Rule::unique('tickets')->where(function ($query) {
                    return $query
                        ->where('customer_id', $this->customer_id)
                        ->whereDate('created_at', now()->toDateString());
                }),
            ],
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'status' => 'nullable|in:new,in_progress,processed',
        'answered_at' => 'nullable|date',
        'files.*' => 'file|max:10240',
        ];
    }

     public function messages(): array
    {
        return [
            'customer_id.unique' => 'От одного клиента можно создать только одну заявку в сутки.',
        ];
    }

}
