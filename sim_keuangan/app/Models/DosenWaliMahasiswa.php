<?php

namespace App\Models;

use Database\Factories\DosenWaliMahasiswaFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(DosenWaliMahasiswaFactory::class)]
class DosenWaliMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'dosen_wali_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_wali_id',
    ];

    protected $casts = [
        'mahasiswa_id' => 'integer',
        'dosen_wali_id' => 'integer',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'dosen_wali_id');
    }
}
