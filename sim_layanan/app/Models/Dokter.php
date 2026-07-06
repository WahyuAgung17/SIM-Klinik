<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ⚠️ DUMMY SEMENTARA — nanti diganti model final milik Anggota 2.
class Dokter extends Model
{
    protected $table = 'dokter';

    protected $fillable = [
        'nama',
        'spesialisasi',
        'no_str',
        'no_telp',
        'status',
    ];

    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }

    public function pemeriksaan(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }
}
