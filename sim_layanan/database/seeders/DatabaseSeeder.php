<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: pasien & dokter dulu (dummy), baru poli, lalu layanan
        // (layanan butuh poli_id sudah ada). User admin bisa kapan saja.
        $this->call([
            UserSeeder::class,
            PasienSeeder::class,
            DokterSeeder::class,
            PoliSeeder::class,
            LayananSeeder::class,
        ]);
    }
}
