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
        'status',
    ];

    public function penumpang(): BelongsTo
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function kursi(): BelongsTo
    {
        return $this->belongsTo(Kursi::class, 'id_kursi', 'id_kursi');
    }
}
