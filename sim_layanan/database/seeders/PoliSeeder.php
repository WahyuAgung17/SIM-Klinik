<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_poli' => 'Poli Umum', 'deskripsi' => 'Pemeriksaan umum dan konsultasi kesehatan dasar', 'status' => 'aktif'],
            ['nama_poli' => 'Poli Gigi', 'deskripsi' => 'Perawatan dan pemeriksaan gigi', 'status' => 'aktif'],
            ['nama_poli' => 'Poli Anak', 'deskripsi' => 'Pemeriksaan kesehatan anak', 'status' => 'aktif'],
            ['nama_poli' => 'Poli Penyakit Dalam', 'deskripsi' => 'Pemeriksaan penyakit dalam', 'status' => 'tidak_aktif'],
        ];

        foreach ($data as $item) {
            Poli::create($item);
        }
    }
}
