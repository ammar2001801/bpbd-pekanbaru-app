<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanInstansi extends Model
{
    protected $table = 'pengaturan_instansi';

    protected $fillable = [
        'nama_instansi',
        'singkatan',
        'nama_pemda',
        'nama_pimpinan',
        'nip_pimpinan',
        'jabatan_pimpinan',
        'alamat',
        'kontak',
        'email',
        'website',
        'logo_path',
    ];

    public static function getPengaturan(): self
    {
        return self::firstOrCreate([], [
            'nama_instansi' => 'Badan Penanggulangan Bencana Daerah Kota Pekanbaru',
            'singkatan' => 'BPBD Kota Pekanbaru',
            'nama_pemda' => 'Pemerintah Kota Pekanbaru',
            'nama_pimpinan' => 'Zarman Candra, S.STP, M.Si',
            'nip_pimpinan' => '19750510 199402 1 001',
            'jabatan_pimpinan' => 'Kepala Pelaksana BPBD Kota Pekanbaru',
            'alamat' => 'Jl. Mustafa Sari No. 1, Tangkerang Selatan, Kec. Bukit Raya, Kota Pekanbaru, Riau 28126',
            'kontak' => '0811-7604-800 / Call Center 112',
            'email' => 'bpbd@pekanbaru.go.id',
            'website' => 'https://bpbd.pekanbaru.go.id',
        ]);
    }
}
