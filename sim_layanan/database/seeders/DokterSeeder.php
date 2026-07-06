<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

// ⚠️ DUMMY SEMENTARA - data contoh, bukan data asli
class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'dr. Hendra Kusuma', 'spesialisasi' => 'Dokter Umum', 'no_str' => 'STR-001', 'no_telp' => '081298765401', 'status' => 'aktif'],
            ['nama' => 'dr. Maya Anggraini, Sp.A', 'spesialisasi' => 'Spesialis Anak', 'no_str' => 'STR-002', 'no_telp' => '081298765402', 'status' => 'aktif'],
            ['nama' => 'drg. Fajar Ramadhan', 'spesialisasi' => 'Dokter Gigi', 'no_str' => 'STR-003', 'no_telp' => '081298765403', 'status' => 'aktif'],
            ['nama' => 'dr. Indah Permatasari, Sp.PD', 'spesialisasi' => 'Spesialis Penyakit Dalam', 'no_str' => 'STR-004', 'no_telp' => '081298765404', 'status' => 'tidak_aktif'],
        ];

        foreach ($data as $item) {
            Dokter::create($item);
        }
    }
}
