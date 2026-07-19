<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $connection = 'klinik';
    protected $table = 'layanan';

    protected $fillable = [
        'poli_id',
        'nama_layanan',
        'kategori',
        'harga',
        'status',
    ];
}