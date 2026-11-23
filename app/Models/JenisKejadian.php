<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKejadian extends Model
{
    protected $table = 'jenis_kejadian';

    protected $fillable = [
        'nama',
        'slug',
        'warna',
        'ikon',
        'keterangan',
    ];

    public function kejadian(): HasMany
    {
        return $this->hasMany(Kejadian::class);
    }
}
