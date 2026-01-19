<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartCheckoutRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:500'],
            'shipping_method' => ['required', 'string', 'max:120'],
            'shipping_date' => ['required', 'date'],
            'shipping_time' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pemesan wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_method.required' => 'Metode pengiriman wajib dipilih.',
            'shipping_date.required' => 'Tanggal pengiriman wajib diisi.',
            'shipping_time.required' => 'Jam pengiriman wajib dipilih.',
        ];
    }
}
