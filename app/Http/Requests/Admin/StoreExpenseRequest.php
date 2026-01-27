<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'expense_date' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'integer', 'min:1'],
            'category' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'expense_date.required' => 'Tanggal pengeluaran wajib diisi.',
            'expense_date.date_format' => 'Format tanggal harus YYYY-MM-DD.',
            'amount.required' => 'Jumlah pengeluaran wajib diisi.',
            'amount.integer' => 'Jumlah pengeluaran harus berupa angka.',
            'amount.min' => 'Jumlah pengeluaran minimal 1.',
            'category.required' => 'Kategori pengeluaran wajib diisi.',
            'category.max' => 'Kategori maksimal 120 karakter.',
            'description.max' => 'Catatan maksimal 500 karakter.',
        ];
    }
}
