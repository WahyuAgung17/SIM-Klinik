<?php
// app/Models/Patient/Poly/Poly.php
// FIX: $table = 'poly' — sesuai nama tabel di database (tidak perlu rename tabel)

namespace App\Models\Patient\Poly;

use Illuminate\Database\Eloquent\Model;

class Poly extends Model
{
    protected $table = 'poly';  // ← tabel di DB namanya 'poly', bukan 'polies'

    protected $fillable = [
        'code',
        'name',
        'description',
        'location',
        'phone',
        'status',
    ];

    /*|------------------------------------------------------------------| RELATIONSHIP */

    public function doctors()
    {
        return $this->hasMany(
            \App\Models\Patient\Doctor\Doctor::class,
            'poly_id'
        );
    }
}
