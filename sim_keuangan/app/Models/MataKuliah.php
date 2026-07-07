<?php

namespace App\Models;

use Database\Factories\MataKuliahFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(MataKuliahFactory::class)]
class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';

    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'semester',
        'id_prodi',
        'dosen_pengampu_id',
        'status_aktif',
    ];

    protected $casts = [
        'sks' => 'integer',
        'semester' => 'integer',
        'id_prodi' => 'integer',
        'dosen_pengampu_id' => 'integer',
        'status_aktif' => 'boolean',
    ];

    public function dosenPengampu(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'dosen_pengampu_id');
    }

    public function getProdiLabelAttribute(): string
    {
        return Mahasiswa::PRODI_OPTIONS[(int) $this->id_prodi] ?? '-';
    }
}
