<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKunjunganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pasien_id' => ['required', 'exists:pasien,id'],
            'poli_id' => ['required', 'exists:poli,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'keluhan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'pasien_id.required' => 'Pasien wajib dipilih.',
            'poli_id.required' => 'Poli wajib dipilih.',
            'dokter_id.required' => 'Dokter wajib dipilih.',
        ];
    }
}
