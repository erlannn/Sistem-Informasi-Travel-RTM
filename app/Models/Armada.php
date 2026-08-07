<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Armada extends Model
{
    use HasFactory;

    protected $table = 'armadas';
    protected $primaryKey = 'id_armada';

    protected $fillable = [
        'merk',
        'warna',
        'status',
    ];

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'id_armada', 'id_armada');
    }
}
