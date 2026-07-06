<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanMasuk extends Model
{
    protected $table = 'pesan_masuk';

    protected $fillable = [
        'nama',
        'no_telp',
        'subjek',
        'pesan',
        'status',
    ];

    public function scopeBelumDibaca($query)
    {
        return $query->where('status', 'belum_dibaca');
    }
}
