<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'phone' => [
            'sometimes',
            'required',
            'string',
            'regex:/^\+[1-9]\d{1,14}$/',
            'unique:customers,phone,' . $this->customer->id,
            ],
            'email' => 'sometimes|nullable|string|email|max:255|unique:customers,email,' . $this->customer->id,
        ];
    }

    public function messages(): array
    {
        return [
        'phone.regex' => 'Телефон должен быть в формате E.164, например +71234567890' . $this->customer->id,
       ];
    }

}
