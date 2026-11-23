<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class FotoKejadian extends Model
{
    protected $table = 'foto_kejadian';

    protected $fillable = [
        'kejadian_id',
        'file_path',
        'caption',
    ];

    public function kejadian(): BelongsTo
    {
        return $this->belongsTo(Kejadian::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
