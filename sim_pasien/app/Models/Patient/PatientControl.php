<?php
// app/Models/Patient/PatientControl.php
// FIX: tambah control_time di fillable, update getStatusBadgeAttribute

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientControl extends Model
{
    protected $table = 'patient_controls';

    protected $fillable = [
        'patient_id',
        'visit_id',
        'doctor_id',
        'control_date',
        'control_time',   // FIX: tambah kolom jam
        'notes',
        'status',
    ];

    protected $casts = [
        'control_date' => 'date',
    ];

    /*|------------------------------------------------------------------| RELATIONSHIP */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function doctor()
    {
        return $this->belongsTo(
            \App\Models\Patient\Doctor\Doctor::class,
            'doctor_id'
        );
    }

    /*|------------------------------------------------------------------| ACCESSOR */

    // FIX: badge warna sesuai status baru
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Menunggu'    => 'warning',
            'Sudah Datang'=> 'success',
            'Terlewat'    => 'danger',
            default       => 'secondary',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'Menunggu'    => 'fas fa-clock',
            'Sudah Datang'=> 'fas fa-check-circle',
            'Terlewat'    => 'fas fa-times-circle',
            default       => 'fas fa-question',
        };
    }
}
