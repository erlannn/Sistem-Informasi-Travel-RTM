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

    /**
     * Check if the schedule departure date and time have already passed.
     */
    public function isPast(): bool
    {
        if (!$this->tanggal || !$this->jam) {
            return false;
        }

        $departureDateTime = \Carbon\Carbon::parse($this->tanggal . ' ' . $this->jam);
        return $departureDateTime->isPast();
    }

    /**
     * Scope query to only include schedules with an active armada.
     */
    public function scopeArmadaAktif($query)
    {
        return $query->whereHas('armada', function ($q) {
            $q->where('status', 'Aktif');
        });
    }

    /**
     * Scope query to only include future / upcoming schedules.
     */
    public function scopeMendatang($query)
    {
        $today = now()->toDateString();
        $currentTime = now()->format('H:i:s');

        return $query->where(function ($q) use ($today, $currentTime) {
            $q->where('tanggal', '>', $today)
              ->orWhere(function ($q2) use ($today, $currentTime) {
                  $q2->whereDate('tanggal', $today)
                     ->where('jam', '>', $currentTime);
              });
        });
    }

    /**
     * Scope query to validate schedules for a given date input.
     */
    public function scopeValidForDate($query, ?string $tanggal)
    {
        if (!$tanggal) {
            return $this->scopeMendatang($query);
        }

        $today = now()->toDateString();
        $currentTime = now()->format('H:i:s');

        if ($tanggal === $today) {
            return $query->whereDate('tanggal', $tanggal)->where('jam', '>', $currentTime);
        } elseif ($tanggal < $today) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereDate('tanggal', $tanggal);
    }
}
