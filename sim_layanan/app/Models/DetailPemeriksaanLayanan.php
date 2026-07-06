<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemeriksaanLayanan extends Model
{
    protected $table = 'detail_pemeriksaan_layanan';

    protected $fillable = [
        'pemeriksaan_id',
        'layanan_id',
        'harga',
        'jumlah',
        'subtotal',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // Hitung subtotal otomatis setiap kali data disimpan.
        static::saving(function (self $detail) {
            $detail->subtotal = $detail->harga * $detail->jumlah;
        });
    }

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}
