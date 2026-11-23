<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InstansiPendukung extends Model
{
    protected $table = 'instansi_pendukung';

    protected $fillable = [
        'nama_instansi',
        'kontak',
    ];

    public function kejadian(): BelongsToMany
    {
        return $this->belongsToMany(Kejadian::class, 'kejadian_instansi', 'instansi_pendukung_id', 'kejadian_id');
    }
}
