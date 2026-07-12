<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model\patient;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [

        'setting_key',
        'setting_value'

    ];
}