<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $primaryKey = 'id';

    protected $fillable = [

        'medical_record_number',
        'nik',
        'family_card_number',
        'full_name',
        'nickname',
        'gender',
        'birth_place',
        'birth_date',
        'blood_type',
        'religion',
        'marital_status',
        'occupation',
        'phone',
        'email',
        'address',
        'rt',
        'rw',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'insurance_type',
        'bpjs_number',
        'insurance_number',
        'blood_pressure',
        'allergy',
        'medical_notes',
        'photo',
        'status',

    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function documents()
    {
        return $this->hasMany(PatientDocument::class);
    }

    public function controls()
    {
        return $this->hasMany(PatientControl::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getAgeAttribute()
    {
        return $this->birth_date
            ? $this->birth_date->age
            : null;
    }

    public function getFullAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->address,
            'RT '.$this->rt,
            'RW '.$this->rw,
            $this->village,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code,
        ]));
    }
}