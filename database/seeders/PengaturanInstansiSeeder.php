<?php

namespace Database\Seeders;

use App\Models\PengaturanInstansi;
use Illuminate\Database\Seeder;

class PengaturanInstansiSeeder extends Seeder
{
    public function run(): void
    {
        PengaturanInstansi::updateOrCreate(
            ['id' => 1],
            [
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
                'logo_path' => 'logo/logo-bpbd.png',
            ]
        );
    }
}
