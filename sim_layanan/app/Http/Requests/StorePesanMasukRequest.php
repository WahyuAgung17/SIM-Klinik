<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesanMasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'no_telp' => ['required', 'string', 'max:20'],
            'subjek' => ['required', 'string', 'max:150'],
            'pesan' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'subjek.required' => 'Subjek pesan wajib diisi.',
            'pesan.required' => 'Isi pesan wajib diisi.',
        ];
    }
}
