<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_armada',
        'id_sopir',
        'asal',
        'tujuan',
        'tanggal',
        'jam',
        'harga',
        'bagi_hasil_sopir',
    ];

    public function getSetoranPerusahaanAttribute(): float
    {
        return max(0, (float) $this->harga - (float) ($this->bagi_hasil_sopir ?? 0));
    }

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'id_armada', 'id_armada');
    }

    public function sopir(): BelongsTo
    {
        return $this->belongsTo(Sopir::class, 'id_sopir', 'id_sopir');
    }

    public function kursis(): HasMany
    {
        return $this->hasMany(Kursi::class, 'id_jadwal', 'id_jadwal');
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_jadwal', 'id_jadwal');
    }
}
