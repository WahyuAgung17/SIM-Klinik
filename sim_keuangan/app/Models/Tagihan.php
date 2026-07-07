<?php

namespace App\Models;

use Database\Factories\TagihanFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(TagihanFactory::class)]
class Tagihan extends Model
{
    use HasFactory;

    protected $connection = 'sikeu';

    protected $table = 'tagihan';

    protected $fillable = [
        'nim',
        'periode',
        'total_tagihan',
        'status_bayar',
        'order_id',
        'snap_token',
        'paid_at',
    ];

    protected $casts = [
        'nim' => 'integer',
        'total_tagihan' => 'integer',
        'paid_at' => 'datetime',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'id');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_bayar) {
            'Lunas' => 'badge-success',
            'Pending' => 'badge-warning',
            'Gagal' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}
