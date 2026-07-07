<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Throwable;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        if (MataKuliah::query()->exists()) {
            return;
        }

        $dosenIds = $this->getDosenIds();

        if ($dosenIds === []) {
            MataKuliah::factory()->count(12)->create();
            return;
        }

        MataKuliah::factory()
            ->count(12)
            ->state(fn () => ['dosen_pengampu_id' => Arr::random($dosenIds)])
            ->create();
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
