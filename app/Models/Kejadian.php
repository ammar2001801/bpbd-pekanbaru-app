<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kejadian extends Model
{
    use SoftDeletes;

    protected $table = 'kejadian';

    protected $fillable = [
        'nomor_laporan',
        'user_id',
        'tanggal_kejadian',
        'jam_kejadian',
        'jam_selesai',
        'jenis_kejadian_id',
        'kecamatan_id',
        'kelurahan_id',
        'lokasi_detail',
        'latitude',
        'longitude',
        'kronologi',
        'tindakan',
        'jumlah_personel',
        'sumber_informasi',
        'luas_terbakar_ha',
        'detail_hewan',
        'korban_meninggal',
        'korban_luka',
        'kk_terdampak',
        'jiwa_terdampak',
        'kerusakan_fasilitas',
        'status',
        'catatan_status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kejadian' => 'date',
            'latitude' => 'float',
            'longitude' => 'float',
            'luas_terbakar_ha' => 'float',
            'korban_meninggal' => 'integer',
            'korban_luka' => 'integer',
            'kk_terdampak' => 'integer',
            'jiwa_terdampak' => 'integer',
            'jumlah_personel' => 'integer',
        ];
    }

    /**
     * Generate auto nomor laporan dengan format BPBD-PKU/YYYY/MM/XXXX
     * Reset nomor urut setiap bulan baru.
     */
    public static function generateNomorLaporan(?string $tanggal = null): string
    {
        $date = $tanggal ? Carbon::parse($tanggal) : Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $prefix = "BPBD-PKU/{$year}/{$month}/";

        // Cari nomor terakhir di bulan dan tahun yang bersangkutan (termasuk yang di soft-delete agar nomor tidak bentrok)
        $lastRecord = self::withTrashed()
            ->where('nomor_laporan', 'like', "{$prefix}%")
            ->orderBy('nomor_laporan', 'desc')
            ->first();

        if ($lastRecord && preg_match('/\/(\d{4})$/', $lastRecord->nomor_laporan, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jenisKejadian(): BelongsTo
    {
        return $this->belongsTo(JenisKejadian::class);
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function instansiPendukung(): BelongsToMany
    {
        return $this->belongsToMany(InstansiPendukung::class, 'kejadian_instansi', 'kejadian_id', 'instansi_pendukung_id');
    }

    public function foto(): HasMany
    {
        return $this->hasMany(FotoKejadian::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nomor_laporan', 'like', "%{$search}%")
                    ->orWhere('lokasi_detail', 'like', "%{$search}%")
                    ->orWhere('kronologi', 'like', "%{$search}%")
                    ->orWhere('tindakan', 'like', "%{$search}%")
                    ->orWhere('sumber_informasi', 'like', "%{$search}%");
            });
        });

        $query->when($filters['jenis_id'] ?? null, function ($q, $jenisId) {
            $q->where('jenis_kejadian_id', $jenisId);
        });

        $query->when($filters['kecamatan_id'] ?? null, function ($q, $kecamatanId) {
            $q->where('kecamatan_id', $kecamatanId);
        });

        $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        });

        $query->when($filters['tanggal'] ?? null, function ($q, $tanggal) {
            $q->whereDate('tanggal_kejadian', $tanggal);
        });

        $query->when($filters['tanggal_mulai'] ?? null, function ($q, $mulai) {
            $q->whereDate('tanggal_kejadian', '>=', $mulai);
        });

        $query->when($filters['tanggal_selesai'] ?? null, function ($q, $selesai) {
            $q->whereDate('tanggal_kejadian', '<=', $selesai);
        });

        $query->when($filters['bulan'] ?? null, function ($q, $bulan) {
            $q->whereMonth('tanggal_kejadian', $bulan);
        });

        $query->when($filters['tahun'] ?? null, function ($q, $tahun) {
            $q->whereYear('tanggal_kejadian', $tahun);
        });
    }
}
