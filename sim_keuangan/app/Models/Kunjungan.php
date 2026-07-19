<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $guarded = ['id'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }
}