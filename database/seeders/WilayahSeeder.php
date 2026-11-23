<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * CATATAN PENTING VALIDASI DATA WILAYAH:
     * Daftar 15 Kecamatan dan Kelurahan di bawah ini merujuk pada Peraturan Daerah Kota Pekanbaru
     * Nomor 2 Tahun 2020 tentang Penataan dan Pemekaran Kecamatan di Lingkungan Pemerintah Kota Pekanbaru.
     * Sebelum diimplementasikan pada server produksi resmi, data wilayah ini HARUS diverifikasi manual
     * bersama Bagian Tata Pemerintahan Sekretariat Daerah Kota Pekanbaru dan Dinas Kependudukan & Pencatatan Sipil.
     */
    public function run(): void
    {
        $wilayah = [
            'Binawidya' => [
                'Binawidya', 'Delima', 'Tobek Godang', 'Simpang Baru', 'Sungai Sibam'
            ],
            'Bukit Raya' => [
                'Air Dingin', 'Simpang Tiga', 'Tangkerang Labuai', 'Tangkerang Selatan', 'Tangkerang Utara'
            ],
            'Kulim' => [
                'Kulim', 'Mentangor', 'Sialang Rampai', 'Pebatuan', 'Bencah Lesung'
            ],
            'Lima Puluh' => [
                'Rintis', 'Sekip', 'Tanjung Rhu', 'Pesisir'
            ],
            'Marpoyan Damai' => [
                'Maharatu', 'Perhentian Marpoyan', 'Sidomulyo Timur', 'Tangkerang Barat', 'Tangkerang Tengah', 'Wonorejo'
            ],
            'Payung Sekaki' => [
                'Air Hitam', 'Bandar Raya', 'Labuh Baru Barat', 'Labuh Baru Timur', 'Tampan', 'Tirta Siak'
            ],
            'Pekanbaru Kota' => [
                'Simpang Empat', 'Sumahilang', 'Tanah Datar', 'Kota Baru', 'Kota Tinggi', 'Sukaramai'
            ],
            'Rumbai' => [
                'Sri Meranti', 'Palas', 'Umban Sari', 'Lembah Damai', 'Limbungan Baru'
            ],
            'Rumbai Barat' => [
                'Muara Fajar Barat', 'Muara Fajar Timur', 'Rantau Panjang', 'Agrowisata', 'Maharani'
            ],
            'Rumbai Timur' => [
                'Tebing Tinggi Okura', 'Sungai Ukai', 'Sungai Ambang', 'Lembah Sari', 'Limbungan'
            ],
            'Sail' => [
                'Cinta Raja', 'Sukamaju', 'Sukamulia'
            ],
            'Senapelan' => [
                'Kampung Bandar', 'Kampung Baru', 'Kampung Dalam', 'Padang Bulan', 'Padang Terubuk', 'Sago'
            ],
            'Sukajadi' => [
                'Harjosari', 'Jadirejo', 'Kampung Melayu', 'Kedung Sari', 'Kotabaru', 'Pulau Karam', 'Sukajadi'
            ],
            'Tenayan Raya' => [
                'Bambu Kuning', 'Bentaian', 'Industri Tenayan', 'Melebung', 'Rejosari', 'Sialang Sakti', 'Tangkerang Timur', 'Tuah Negeri'
            ],
            'Tuah Madani' => [
                'Tuah Madani', 'Tuah Karya', 'Sialang Munggu', 'Sidomulyo Barat', 'Air Putih'
            ],
        ];

        foreach ($wilayah as $namaKecamatan => $kelurahans) {
            $kecamatan = Kecamatan::firstOrCreate(['nama_kecamatan' => $namaKecamatan]);

            foreach ($kelurahans as $namaKelurahan) {
                Kelurahan::firstOrCreate([
                    'kecamatan_id' => $kecamatan->id,
                    'nama_kelurahan' => $namaKelurahan,
                ]);
            }
        }
    }
}
