<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $connection = 'klinik';
    protected $table = 'kunjungan';

    protected $fillable = [
        'no_kunjungan',
        'pasien_id',
        'poli_id',
        'dokter_id',
        'tanggal_kunjungan',
        'keluhan',
        'status_kunjungan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'datetime',
    ];

    // pasien_id -> tim_pasien.pasien (lintas database)
    // dokter_id -> tim_pegawai.dokter (lintas database)
    // poli_id   -> tim_klinik.poli (satu database, boleh relasi biasa)
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}