<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    public const UNIT_KERJA_OPTIONS = [
        1 => 'Sistem Informasi',
        2 => 'Teknik Informatika',
        3 => 'Teknik Komputer',
    ];

    public const JENIS_PEGAWAI_OPTIONS = [
        'Dosen',
        'Tenaga Kependidikan',
    ];

    public const STATUS_KEPEGAWAIAN_OPTIONS = [
        'Tetap',
        'Kontrak',
    ];

    protected $connection = 'simpeg';

    protected $table = 'pegawai';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nip',
        'nama',
        'jenis_pegawai',
        'status_kepegawaian',
        'unit_kerja',
    ];

    protected $casts = [
        'unit_kerja' => 'integer',
    ];

    public function scopeDosen(Builder $query): Builder
    {
        return $query->where('jenis_pegawai', 'Dosen');
    }

    public function getUnitKerjaLabelAttribute(): string
    {
        return self::UNIT_KERJA_OPTIONS[$this->unit_kerja] ?? '-';
    }
}
