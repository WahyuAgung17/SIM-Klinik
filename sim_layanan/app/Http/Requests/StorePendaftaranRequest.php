<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi form pendaftaran berobat mandiri oleh PASIEN/UMUM (publik, tanpa login).
 * Berbeda dari StoreKunjunganRequest yang dipakai petugas di modul admin.
 */
class StorePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Data pasien - jika NIK sudah terdaftar, data lama akan dipakai.
            'nik' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_telp' => ['required', 'string', 'max:20'],

            // Data kunjungan
            'poli_id' => ['required', 'exists:poli,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'keluhan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_telp.required' => 'Nomor HP wajib diisi.',
            'poli_id.required' => 'Silakan pilih poli tujuan.',
            'dokter_id.required' => 'Silakan pilih dokter.',
            'tanggal_kunjungan.required' => 'Tanggal berobat wajib dipilih.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal berobat tidak boleh sebelum hari ini.',
        ];
    }
}
