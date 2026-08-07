<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kursi extends Model
{
    use HasFactory;

    protected $table = 'kursis';
    protected $primaryKey = 'id_kursi';

    protected $fillable = [
        'id_jadwal',
        'nomor_kursi',
        'status',
    ];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_kursi', 'id_kursi');
    }
}
