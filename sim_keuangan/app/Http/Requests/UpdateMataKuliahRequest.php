<?php

namespace App\Http\Requests;

use App\Models\Mahasiswa;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMataKuliahRequest extends FormRequest
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
            'kode' => ['required', 'string', 'max:20', Rule::unique('mata_kuliah', 'kode')->ignore($this->route('id'))],
            'nama' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'prodi' => ['required', 'integer', Rule::in(array_keys(Mahasiswa::PRODI_OPTIONS))],
            'dosen_pengampu_id' => [
                'required',
                'integer',
                Rule::exists('simpeg.pegawai', 'id')->where(fn ($query) => $query->where('jenis_pegawai', 'Dosen')),
            ],
            'status_aktif' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'kode' => 'kode mata kuliah',
            'nama' => 'nama mata kuliah',
            'sks' => 'SKS',
            'semester' => 'semester',
            'prodi' => 'program studi',
            'dosen_pengampu_id' => 'dosen pengampu',
            'status_aktif' => 'status aktif',
        ];
    }
}
