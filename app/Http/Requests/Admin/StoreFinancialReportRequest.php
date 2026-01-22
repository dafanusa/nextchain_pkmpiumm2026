<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinancialReportRequest extends FormRequest
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
            'report_name' => ['nullable', 'string', 'max:120'],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'order_ids' => ['required', 'array', 'min:1'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'report_name.max' => 'Nama laporan maksimal 120 karakter.',
            'date_from.date_format' => 'Format tanggal awal harus YYYY-MM-DD.',
            'date_to.date_format' => 'Format tanggal akhir harus YYYY-MM-DD.',
            'date_to.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal.',
            'order_ids.required' => 'Pilih minimal 1 order untuk dibuat laporan.',
            'order_ids.array' => 'Order yang dipilih tidak valid.',
            'order_ids.min' => 'Pilih minimal 1 order untuk dibuat laporan.',
            'order_ids.*.exists' => 'Order yang dipilih tidak ditemukan.',
        ];
    }
}
