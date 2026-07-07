<?php

namespace Database\Factories;

use App\Models\DosenWaliMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;
use Throwable;

/**
 * @extends Factory<DosenWaliMahasiswa>
 */
class DosenWaliMahasiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mahasiswa_id' => $this->randomMahasiswaId(),
            'dosen_wali_id' => $this->randomDosenId(),
        ];
    }

    private function randomMahasiswaId(): int|Factory
    {
        $mahasiswaId = Mahasiswa::query()
            ->whereDoesntHave('dosenWaliMahasiswa')
            ->inRandomOrder()
            ->value('id');

        return $mahasiswaId ?? Mahasiswa::factory();
    }

    private function randomDosenId(): ?int
    {
        try {
            return Pegawai::query()->dosen()->inRandomOrder()->value('id');
        } catch (Throwable) {
            return null;
        }
    }
}
