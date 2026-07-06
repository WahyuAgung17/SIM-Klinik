<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = [
        'poli_id',
        'nama_layanan',
        'kategori',
        'harga',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function detailPemeriksaan(): HasMany
    {
        return $this->hasMany(DetailPemeriksaanLayanan::class);
    }

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
