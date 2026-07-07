<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTagihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', Rule::exists('mahasiswa', 'id')],
            'semester' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'integer', 'min:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Mahasiswa wajib dipilih.',
            'student_id.exists' => 'Mahasiswa yang dipilih tidak ditemukan.',
            'semester.required' => 'Periode tagihan wajib diisi.',
            'amount.required' => 'Total tagihan wajib diisi.',
            'amount.integer' => 'Total tagihan harus berupa angka bulat.',
            'amount.min' => 'Total tagihan minimal Rp 1.000.',
        ];
    }
}
