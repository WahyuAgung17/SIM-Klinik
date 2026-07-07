<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! Mahasiswa::query()->exists()) {
            Mahasiswa::factory()->count(100)->create();
        }

        $this->call([
            MataKuliahSeeder::class,
            DosenWaliMahasiswaSeeder::class,
            TagihanSeeder::class,
        ]);
    }
}
