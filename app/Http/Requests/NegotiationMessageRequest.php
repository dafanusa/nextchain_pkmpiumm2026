<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NegotiationMessageRequest extends FormRequest
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
            'offer_id' => ['required', 'integer', 'exists:negotiation_offers,id'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'offer_id.required' => 'Tawaran belum dipilih.',
            'offer_id.exists' => 'Tawaran tidak ditemukan.',
            'message.required' => 'Pesan wajib diisi.',
        ];
    }
}
