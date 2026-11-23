<?php

namespace Database\Seeders;

use App\Models\JenisKejadian;
use App\Models\InstansiPendukung;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterKejadianSeeder extends Seeder
{
    public function run(): void
    {
        $jenisList = [
            [
                'nama' => 'Kebakaran Lahan',
                'warna' => '#EF4444', // Merah Terang
                'ikon' => 'fire',
                'keterangan' => 'Kebakaran semak belukar, gambut, atau lahan terbuka/perkebunan.',
            ],
            [
                'nama' => 'Kebakaran Permukiman',
                'warna' => '#EA580C', // Oranye Tua
                'ikon' => 'home',
                'keterangan' => 'Kebakaran rumah tinggal, ruko, gedung kantor, atau fasilitas umum.',
            ],
            [
                'nama' => 'Banjir',
                'warna' => '#2563EB', // Biru
                'ikon' => 'water',
                'keterangan' => 'Genangan air luapan sungai (Siak/Sail), drainase tersumbat, atau curah hujan tinggi.',
            ],
            [
                'nama' => 'Pohon Tumbang',
                'warna' => '#059669', // Hijau Emerald
                'ikon' => 'tree',
                'keterangan' => 'Pohon pelindung/hutan tumbang menghalangi jalan, menimpa jaringan listrik atau bangunan.',
            ],
            [
                'nama' => 'Evakuasi Hewan Liar',
                'warna' => '#7C3AED', // Ungu
                'ikon' => 'shield',
                'keterangan' => 'Penyelamatan dan evakuasi satwa liar (ular berbisa, tawon vespa, biawak, kera, buaya).',
            ],
            [
                'nama' => 'Angin Kencang',
                'warna' => '#0891B2', // Cyan
                'ikon' => 'wind',
                'keterangan' => 'Hujan badai, angin kencang / puting beliung yang merusak atap dan fasilitas warga.',
            ],
            [
                'nama' => 'Tanah Longsor',
                'warna' => '#B45309', // Cokelat Amber
                'ikon' => 'alert-triangle',
                'keterangan' => 'Pergerakan tanah atau tebing bibir sungai/jurang yang amblas.',
            ],
            [
                'nama' => 'Lainnya',
                'warna' => '#4B5563', // Abu-abu
                'ikon' => 'help-circle',
                'keterangan' => 'Kejadian bencana atau kedaruratan lain yang belum terklasifikasi.',
            ],
        ];

        foreach ($jenisList as $item) {
            JenisKejadian::updateOrCreate(
                ['slug' => Str::slug($item['nama'])],
                [
                    'nama' => $item['nama'],
                    'warna' => $item['warna'],
                    'ikon' => $item['ikon'],
                    'keterangan' => $item['keterangan'],
                ]
            );
        }

        $instansiList = [
            'Dinas Pemadam Kebakaran dan Penyelamatan (DPKP) Kota Pekanbaru',
            'TNI (Kodim 0301/Pekanbaru)',
            'Polresta Pekanbaru / Polsek Setempat',
            'Balai Besar KSDA Riau',
            'BPBD Provinsi Riau',
            'Palang Merah Indonesia (PMI) Kota Pekanbaru',
            'Tagana / Dinas Sosial Kota Pekanbaru',
            'Dinas Perhubungan Kota Pekanbaru',
            'Satpol PP Kota Pekanbaru',
            'PLN UP3 Pekanbaru',
            'Dinas Lingkungan Hidup dan Kebersihan (DLHK)',
            'Relawan Masyarakat Peduli Bencana (MPB)',
        ];

        foreach ($instansiList as $nama) {
            InstansiPendukung::firstOrCreate(['nama_instansi' => $nama]);
        }
    }
}
