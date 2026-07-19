<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    // Menentukan nama tabel karena default Laravel mencari bentuk plural (tagihans)
    protected $table = 'tagihan';

    protected $fillable = [
        'no_tagihan',
        'kunjungan_id',
        'total_tagihan',
        'status_pembayaran',
        'metode_pembayaran',
        'snap_token',
        'midtrans_order_id',
        'tanggal_tagihan',
        'tanggal_bayar'
    ];

    // Jika foreign key di tim_klinik.kunjungan berbeda database, pastikan relasinya didefinisikan dengan hati-hati.
    
    /**
     * Relasi ke tabel Pembayaran (One-to-One / One-to-Many)
     */
    public function pembayaran()
    {
        // Parameter: Model, Foreign Key di tabel target, Local Key di tabel ini
        return $this->hasOne(Pembayaran::class, 'tagihan_id', 'id');
    }
}