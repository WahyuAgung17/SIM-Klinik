<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ⚠️ DUMMY SEMENTARA — nanti diganti model final milik Anggota 1.
class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telp',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
