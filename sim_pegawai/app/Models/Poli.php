<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'polis';
    protected $fillable = ['nama_poli', 'deskripsi', 'status'];

    public function dokters()
    {
        return $this->hasMany(Dokter::class, 'poli_id');
    }
}