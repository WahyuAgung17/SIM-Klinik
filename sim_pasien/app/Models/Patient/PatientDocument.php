<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientDocument extends Model
{
    use HasFactory;

    protected $table = 'patient_documents';

    protected $fillable = [
        'patient_id',
        'document_type',
        'file_name',
        'file_path',
        'uploaded_by',
    ];

    /**
     * Relasi ke pasien
     */
    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id',
            'id'
        );
    }

    /**
     * URL file
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Nama ekstensi file
     */
    public function getExtensionAttribute()
    {
        return strtolower(
            pathinfo($this->file_name, PATHINFO_EXTENSION)
        );
    }

    /**
     * Apakah file berupa gambar
     */
    public function getIsImageAttribute()
    {
        return in_array(
            $this->extension,
            ['jpg', 'jpeg', 'png']
        );
    }

    /**
     * Apakah file berupa PDF
     */
    public function getIsPdfAttribute()
    {
        return $this->extension === 'pdf';
    }
}