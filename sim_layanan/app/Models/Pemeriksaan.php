<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';

    protected $fillable = [
        'kunjungan_id',
        'dokter_id',
        'diagnosa',
        'catatan_pemeriksaan',
        'resep',
    ];

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    // Relasi ke model Dokter milik Anggota 2.
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    public function detailLayanan(): HasMany
    {
        return $this->hasMany(DetailPemeriksaanLayanan::class);
    }

    public function totalBiaya(): float
    {
        return $this->detailLayanan()->sum('subtotal');
    }
}
