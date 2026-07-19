<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihans';
    protected $guarded = ['id'];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_id', 'id');
    }
    
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id', 'id');
    }
}