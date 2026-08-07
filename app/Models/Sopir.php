<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sopir extends Model
{
    use HasFactory;

    protected $table = 'sopirs';
    protected $primaryKey = 'id_sopir';

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'gaji',
    ];

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'id_sopir', 'id_sopir');
    }
}
