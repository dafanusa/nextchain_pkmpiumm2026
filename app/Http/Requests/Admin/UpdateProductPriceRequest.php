<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price_min' => ['required', 'integer', 'min:0'],
            'price_max' => ['required', 'integer', 'min:0', 'gte:price_min'],
        ];
    }

    public function messages(): array
    {
        return [
            'price_min.required' => 'Harga minimum wajib diisi.',
            'price_max.required' => 'Harga maksimum wajib diisi.',
            'price_max.gte' => 'Harga maksimum harus lebih besar atau sama dengan harga minimum.',
        ];
    }
}
