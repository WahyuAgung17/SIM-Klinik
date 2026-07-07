<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        if (Tagihan::query()->exists()) {
            return;
        }

        if (! Mahasiswa::query()->exists()) {
            Mahasiswa::factory()->count(20)->create();
        }

        Tagihan::factory()->count(35)->create();
    }
}
