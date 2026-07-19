<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $connection = 'klinik';
    protected $table = 'pemeriksaan';

    protected $fillable = [
        'kunjungan_id',
        'dokter_id',
        'diagnosa',
        'catatan_pemeriksaan',
        'resep',
    ];

    // kunjungan_id -> tim_klinik.kunjungan (satu database)
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id');
    }

    // dokter_id -> tim_pegawai.dokter (lintas database, tanpa relasi Eloquent)
}