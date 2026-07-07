<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDosenWaliMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mahasiswa_id' => [
                'required',
                'integer',
                'exists:mahasiswa,id',
                Rule::unique('dosen_wali_mahasiswa', 'mahasiswa_id')->ignore($this->route('id')),
            ],
            'dosen_wali_id' => [
                'required',
                'integer',
                Rule::exists('simpeg.pegawai', 'id')->where(fn ($query) => $query->where('jenis_pegawai', 'Dosen')),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'mahasiswa_id' => 'mahasiswa',
            'dosen_wali_id' => 'dosen wali',
        ];
    }
}
