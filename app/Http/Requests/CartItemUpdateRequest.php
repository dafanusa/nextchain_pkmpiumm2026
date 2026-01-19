<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemUpdateRequest extends FormRequest
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
            'qty' => ['nullable', 'integer', 'min:1'],
            'selected' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'qty.min' => 'Jumlah minimal 1.',
        ];
    }
}
