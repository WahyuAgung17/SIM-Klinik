<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePemeriksaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnosa' => ['required', 'string', 'max:1000'],
            'catatan_pemeriksaan' => ['nullable', 'string', 'max:1000'],
            'resep' => ['nullable', 'string', 'max:1000'],
            'layanan_id' => ['required', 'array', 'min:1'],
            'layanan_id.*' => ['exists:layanan,id'],
            'jumlah' => ['required', 'array'],
            'jumlah.*' => ['integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'diagnosa.required' => 'Diagnosa wajib diisi.',
            'layanan_id.required' => 'Pilih minimal 1 layanan/tindakan.',
        ];
    }
}
