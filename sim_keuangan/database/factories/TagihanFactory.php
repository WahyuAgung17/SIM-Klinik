<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tagihan>
 */
class TagihanFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['Belum Lunas', 'Pending', 'Lunas', 'Gagal']);

        return [
            'nim' => $this->randomMahasiswaId(),
            'periode' => $this->faker->randomElement([
                '2024/2025 Ganjil',
                '2024/2025 Genap',
                '2025/2026 Ganjil',
                '2025/2026 Genap',
            ]),
            'total_tagihan' => $this->faker->randomElement([
                2500000,
                3000000,
                3500000,
                4000000,
                4500000,
            ]),
            'status_bayar' => $status,
            'order_id' => $status === 'Belum Lunas' ? null : 'PAY-TEST-'.$this->faker->unique()->numerify('########'),
            'snap_token' => $status === 'Pending' ? $this->faker->sha256() : null,
            'paid_at' => $status === 'Lunas' ? $this->faker->dateTimeBetween('-6 months') : null,
        ];
    }

    private function randomMahasiswaId(): int|Factory
    {
        $mahasiswaId = Mahasiswa::query()->inRandomOrder()->value('id');

        return $mahasiswaId ?? Mahasiswa::factory();
    }
}
