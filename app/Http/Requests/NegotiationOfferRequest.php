<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NegotiationOfferRequest extends FormRequest
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
            'price' => ['required', 'integer', 'min:1'],
            'qty' => ['required', 'integer', 'min:1'],
            'channel' => ['nullable', 'string', 'in:chat,bid'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => 'Harga wajib diisi.',
            'price.min' => 'Harga minimal 1.',
            'qty.required' => 'Jumlah wajib diisi.',
            'qty.min' => 'Jumlah minimal 1.',
            'channel.in' => 'Tipe tawaran tidak valid.',
        ];
    }
}
