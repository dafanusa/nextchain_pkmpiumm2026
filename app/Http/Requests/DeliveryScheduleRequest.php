<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryScheduleRequest extends FormRequest
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
            'destination' => ['required', 'string', 'max:255'],
            'delivery_date' => ['required', 'date'],
            'delivery_time' => ['required', 'string', 'max:80'],
            'schedule_type' => ['required', 'in:scheduled,pickup'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'destination.required' => 'Tujuan pengiriman wajib diisi.',
            'delivery_date.required' => 'Tanggal pengiriman wajib diisi.',
            'delivery_time.required' => 'Jam pengiriman wajib diisi.',
            'schedule_type.required' => 'Tipe jadwal wajib dipilih.',
            'schedule_type.in' => 'Tipe jadwal tidak valid.',
        ];
    }
}
