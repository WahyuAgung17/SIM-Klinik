<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
        'status',
    ];

    public function layanan(): HasMany
    {
        return $this->hasMany(Layanan::class);
    }

    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }

    // Relasi ke model Dokter milik Anggota 2.
   // public function dokter(): HasMany
   // {
   //     return $this->hasMany(Dokter::class);
   // }
}
