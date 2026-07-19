<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $connection = 'pegawai';
    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'poli_id',
        'nama_dokter',
        'kode_dokter',
        'spesialisasi',
        'no_hp',
        'foto',
        'status',
    ];

    // Catatan: poli_id di sini menunjuk ke tim_klinik.poli (lintas
    // database), jadi TIDAK dibuatkan relasi Eloquent belongsTo()
    // biasa (Eloquent tidak bisa JOIN otomatis lintas connection).
    // Kalau butuh nama poli dari dokter, query manual pakai
    // DB::connection('pegawai')->table('dokter')
    //   ->join('tim_klinik.poli as p', 'p.id', '=', 'dokter.poli_id')
}