<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualPaymentProofRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_number' => ['required', 'string', 'max:60', 'exists:orders,order_number'],
            'method' => ['required', 'string', 'max:40'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_number.required' => 'Order tidak ditemukan.',
            'order_number.exists' => 'Order tidak ditemukan.',
            'method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 5MB.',
        ];
    }
}
