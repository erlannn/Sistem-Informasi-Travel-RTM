<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_penumpang',
        'id_jadwal',
        'id_kursi',
        'tanggal_pesan',
        'jumlah_penumpang',
        'total_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'status_perjalanan',
        'waktu_bayar',
        'is_setor_admin',
        'tanggal_setor',
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'waktu_bayar' => 'datetime',
        'tanggal_setor' => 'datetime',
        'is_setor_admin' => 'boolean',
        'total_bayar' => 'decimal:2',
    ];

    public function penumpang(): BelongsTo
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function getStatusAttribute(): string
    {
        return $this->status_perjalanan ?? 'Pending';
    }

    public function kursi(): BelongsTo
    {
        return $this->belongsTo(Kursi::class, 'id_kursi', 'id_kursi');
    }
}
