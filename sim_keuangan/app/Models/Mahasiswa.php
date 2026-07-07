<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Database\Factories\MahasiswaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[UseFactory(MahasiswaFactory::class)]
class Mahasiswa extends Model
{
    use HasFactory;

    public const PRODI_OPTIONS = [
        1 => 'Sistem Informasi',
        2 => 'Teknik Informatika',
        3 => 'Teknik Komputer',
        4 => 'TRPL',
    ];

    protected $table = "mahasiswa";

    protected $fillable = ["nim", "nama", "id_prodi", "status_keaktifan"];

    protected $casts = [
        'id_prodi' => 'integer',
        'status_keaktifan' => 'boolean',
    ];

    public function dosenWaliMahasiswa(): HasOne
    {
        return $this->hasOne(DosenWaliMahasiswa::class, 'mahasiswa_id');
    }

    public function getProdiLabelAttribute(): string
    {
        return self::PRODI_OPTIONS[(int) $this->id_prodi] ?? '-';
    }
}
