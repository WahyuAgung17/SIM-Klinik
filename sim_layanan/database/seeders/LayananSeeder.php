<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::insert([

            [

                'poli_id'=>1,
                'nama_layanan'=>'Konsultasi Umum',
                'kategori'=>'Konsultasi',
                'harga'=>50000,
                'status'=>'aktif',

            ],

            [

                'poli_id'=>1,
                'nama_layanan'=>'Pemeriksaan Tekanan Darah',
                'kategori'=>'Pemeriksaan',
                'harga'=>20000,
                'status'=>'aktif',

            ],

            [

                'poli_id'=>1,
                'nama_layanan'=>'Pemeriksaan Gula Darah',
                'kategori'=>'Laboratorium',
                'harga'=>75000,
                'status'=>'aktif',

            ],

            [

                'poli_id'=>1,
                'nama_layanan'=>'Pemeriksaan Kolesterol',
                'kategori'=>'Laboratorium',
                'harga'=>90000,
                'status'=>'aktif',

            ],

            [

                'poli_id'=>1,
                'nama_layanan'=>'Suntik Vitamin',
                'kategori'=>'Tindakan',
                'harga'=>45000,
                'status'=>'aktif',

            ],

            [

                'poli_id'=>1,
                'nama_layanan'=>'Tindakan Luka Ringan',
                'kategori'=>'Tindakan',
                'harga'=>120000,
                'status'=>'aktif',

            ],

            [

                'poli_id'=>1,
                'nama_layanan'=>'Surat Keterangan Sehat',
                'kategori'=>'Administrasi',
                'harga'=>35000,
                'status'=>'aktif',

            ],

        ]);
    }
}