<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLayananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'nama_layanan' => 'required|string|max:255',

            'kategori' => 'required|in:Konsultasi,Pemeriksaan,Laboratorium,Tindakan,Administrasi',

            'poli_id' => 'required|exists:poli,id',

            'harga' => 'required|numeric|min:0',

            'status' => 'required|in:aktif,tidak_aktif',

        ];
    }

    public function messages(): array
    {
        return [

            'nama_layanan.required' => 'Nama layanan wajib diisi.',

            'kategori.required' => 'Kategori wajib dipilih.',

            'poli_id.required' => 'Poli wajib dipilih.',

            'harga.required' => 'Harga layanan wajib diisi.',

            'status.required' => 'Status wajib dipilih.',

        ];
    }
}