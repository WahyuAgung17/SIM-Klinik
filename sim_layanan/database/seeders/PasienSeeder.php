<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;

// ⚠️ DUMMY SEMENTARA - data contoh, bukan data asli
class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['no_rm' => 'RM-0001', 'nama' => 'Siti Amalia', 'nik' => '3372xxxxxxxxxx01', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '1998-03-12', 'alamat' => 'Jl. Slamet Riyadi No. 10, Surakarta', 'no_telp' => '081234567801'],
            ['no_rm' => 'RM-0002', 'nama' => 'Budi Santoso', 'nik' => '3372xxxxxxxxxx02', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '1990-07-22', 'alamat' => 'Jl. Adisucipto No. 5, Surakarta', 'no_telp' => '081234567802'],
            ['no_rm' => 'RM-0003', 'nama' => 'Rani Puspita', 'nik' => '3372xxxxxxxxxx03', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2001-11-05', 'alamat' => 'Jl. Ahmad Yani No. 21, Surakarta', 'no_telp' => '081234567803'],
            ['no_rm' => 'RM-0004', 'nama' => 'Agus Wijaya', 'nik' => '3372xxxxxxxxxx04', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '1985-01-30', 'alamat' => 'Jl. Veteran No. 8, Surakarta', 'no_telp' => '081234567804'],
            ['no_rm' => 'RM-0005', 'nama' => 'Dewi Lestari', 'nik' => '3372xxxxxxxxxx05', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '1995-09-17', 'alamat' => 'Jl. Kartini No. 3, Surakarta', 'no_telp' => '081234567805'],
        ];

        foreach ($data as $item) {
            Pasien::create($item);
        }
    }
}
