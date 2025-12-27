<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => ['required','string',
            'unique:customers,phone',
            'regex:/^\+[1-9]\d{1,14}$/'
            ],
            'email' => 'nullable|string|email|max:255|unique:customers,email',
        ];
    }

    public function messages(): array
{
    return [
        'phone.regex' => 'Телефон должен быть в формате E.164, например +71234567890',
    ];
}

}
