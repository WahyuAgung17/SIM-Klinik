<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemeriksaanLayanan extends Model
{
    protected $connection = 'klinik';
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

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'pemeriksaan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}