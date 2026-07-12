<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model\patient;

class VisitStatusLog extends Model
{
    protected $table = 'visit_status_logs';

    protected $fillable = [

        'visit_id',
        'status',
        'notes',
        'changed_by'

    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}