<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $connection = 'pasien';
    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telp',
        'golongan_darah',
        'alergi',
        'catatan_medis',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}