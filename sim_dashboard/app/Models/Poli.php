<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $connection = 'klinik';
    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
        'status',
    ];
}