<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'nama_kecamatan',
        'kode_wilayah',
    ];

    public function kelurahan(): HasMany
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function kejadian(): HasMany
    {
        return $this->hasMany(Kejadian::class);
    }
}
