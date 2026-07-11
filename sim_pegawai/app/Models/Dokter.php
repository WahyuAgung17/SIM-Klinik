<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokters';
    protected $fillable = ['poli_id', 'nama_dokter', 'kode_dokter', 'spesialisasi', 'no_hp', 'status', 'foto'];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    public function jadwals()
    {
        return $this->hasMany(JadwalDokter::class, 'dokter_id');
    }
}