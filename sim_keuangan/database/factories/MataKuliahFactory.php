<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;
use Throwable;

/**
 * @extends Factory<MataKuliah>
 */
class MataKuliahFactory extends Factory
{
    public function definition(): array
    {
        $prodiId = (int) $this->faker->randomElement(array_keys(Mahasiswa::PRODI_OPTIONS));
        $kodePrefix = match ($prodiId) {
            1 => 'SI',
            2 => 'IF',
            3 => 'TK',
            default => 'TR',
        };

        return [
            'kode' => strtoupper($kodePrefix . $this->faker->unique()->numerify('###')),
            'nama' => $this->faker->randomElement([
                'Basis Data',
                'Struktur Data',
                'Pemrograman Web',
                'Sistem Operasi',
                'Kecerdasan Buatan',
                'Jaringan Komputer',
                'Analisis Sistem',
                'Rekayasa Perangkat Lunak',
            ]),
            'sks' => $this->faker->numberBetween(2, 4),
            'semester' => $this->faker->numberBetween(1, 8),
            'id_prodi' => $prodiId,
            'dosen_pengampu_id' => $this->randomDosenId(),
            'status_aktif' => $this->faker->boolean(85),
        ];
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
