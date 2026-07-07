<?php

namespace Database\Seeders;

use App\Models\DosenWaliMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Throwable;

class DosenWaliMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        if (DosenWaliMahasiswa::query()->exists()) {
            return;
        }

        $dosenIds = $this->getDosenIds();
        $jumlahMahasiswa = Mahasiswa::query()->count();

        if ($dosenIds === [] || $jumlahMahasiswa === 0) {
            return;
        }

        $jumlahData = min($jumlahMahasiswa, 25);

        for ($i = 0; $i < $jumlahData; $i++) {
            DosenWaliMahasiswa::factory()->create([
                'dosen_wali_id' => Arr::random($dosenIds),
            ]);
        }
    }

    /**
     * @return array<int, int>
     */
    private function getDosenIds(): array
    {
        try {
            return Pegawai::query()->dosen()->pluck('id')->all();
        } catch (Throwable) {
            return [];
        }
    }
}
