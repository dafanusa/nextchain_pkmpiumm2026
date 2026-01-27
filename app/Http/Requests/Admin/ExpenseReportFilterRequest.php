<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseReportFilterRequest extends FormRequest
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
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'group_by' => ['nullable', 'in:daily,weekly,monthly'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_from.date_format' => 'Format tanggal awal harus YYYY-MM-DD.',
            'date_to.date_format' => 'Format tanggal akhir harus YYYY-MM-DD.',
            'date_to.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal.',
            'group_by.in' => 'Kelompokkan hanya boleh daily, weekly, atau monthly.',
        ];
    }
}
