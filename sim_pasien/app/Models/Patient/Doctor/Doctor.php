<?php

namespace App\Models\Patient\Doctor;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';

    protected $fillable = [
        'poly_id',
        'doctor_code',
        'sip_number',
        'full_name',
        'specialist',
        'gender',
        'birth_date',
        'phone',
        'email',
        'address',
        'photo',
        'status',
    ];
}