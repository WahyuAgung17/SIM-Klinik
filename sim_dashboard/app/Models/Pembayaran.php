<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id',
        'order_id',
        'payment_type',
        'transaction_status',
        'transaction_time',
        'gross_amount',
        'fraud_status',
        'response_midtrans'
    ];

    /**
     * Relasi balik ke tabel Tagihan
     */
    public function tagihan()
    {
        // Parameter: Model, Foreign Key di tabel ini, Owner Key di tabel target
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'id');
    }
}