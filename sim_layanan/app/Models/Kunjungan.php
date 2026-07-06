<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $fillable = [
        'no_kunjungan',
        'pasien_id',
        'poli_id',
        'dokter_id',
        'tanggal_kunjungan',
        'keluhan',
        'status_kunjungan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'datetime',
    ];

    // Relasi ke model Pasien (saat ini masih model dummy, lihat app/Models/Pasien.php)
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    // Relasi ke model Dokter (saat ini masih model dummy, lihat app/Models/Dokter.php)
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pemeriksaan(): HasOne
    {
        return $this->hasOne(Pemeriksaan::class);
    }

    // Relasi ke model Tagihan milik Anggota 4 - aktifkan setelah tabel tagihan ada.
    // public function tagihan(): HasOne
    // {
    //     return $this->hasOne(Tagihan::class);
    // }

    /**
     * Label status yang enak dibaca untuk ditampilkan di view.
     */
    public function statusLabel(): string
    {
        return match ($this->status_kunjungan) {
            'terdaftar' => 'Terdaftar',
            'menunggu_pemeriksaan' => 'Menunggu Pemeriksaan',
            'sedang_diperiksa' => 'Sedang Diperiksa',
            'selesai_diperiksa' => 'Selesai Diperiksa',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'selesai' => 'Selesai',
            default => ucfirst($this->status_kunjungan),
        };
    }

    /**
     * Generate nomor kunjungan otomatis dengan format: KJ-YYYYMMDD-XXX
     * Contoh: KJ-20260702-001
     */
    public static function generateNoKunjungan(): string
    {
        $tanggal = now()->format('Ymd');
        $jumlahHariIni = self::whereDate('created_at', now()->toDateString())->count();
        $urutan = str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT);

        return "KJ-{$tanggal}-{$urutan}";
    }
}
