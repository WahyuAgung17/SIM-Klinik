<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient\Doctor\Doctor;
use App\Models\Patient\Poly\Poly;

class Visit extends Model
{
    protected $table = 'visits';

    protected $fillable = [
        'visit_number',
        'queue_number',
        'patient_id',
        'doctor_id',
        'poly_id',
        'visit_date',
        'visit_time',
        'payment_type',
        'complaint',
        'diagnosis',
        'status',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function poly()
    {
        return $this->belongsTo(Poly::class, 'poly_id');
    }
}