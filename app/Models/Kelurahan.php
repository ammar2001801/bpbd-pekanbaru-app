<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';

    protected $fillable = [
        'kecamatan_id',
        'nama_kelurahan',
        'kode_pos',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kejadian(): HasMany
    {
        return $this->hasMany(Kejadian::class);
    }
}
