<?php

namespace App\Http\Controllers;

use App\Models\Kejadian;
use App\Models\JenisKejadian;
use App\Models\Kecamatan;
use App\Models\PengaturanInstansi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();

        // Parameter Filter Periode (Default: Tahun saat ini, Bulan: semua atau bulan ini)
        $selectedTahun = (int) $request->input('tahun', $now->year);
        $selectedBulan = $request->input('bulan', 'semua'); // 'semua' atau 1..12

        // Query dasar berfilter tahun dan bulan
        $baseQuery = Kejadian::whereYear('tanggal_kejadian', $selectedTahun);
        if ($selectedBulan && $selectedBulan !== 'semua') {
            $baseQuery->whereMonth('tanggal_kejadian', (int) $selectedBulan);
        }

        // 1. Kartu Metrik Utama
        $totalHariIni = Kejadian::whereDate('tanggal_kejadian', $now->toDateString())->count();
        $totalBulanIni = Kejadian::whereMonth('tanggal_kejadian', $now->month)
            ->whereYear('tanggal_kejadian', $now->year)
            ->count();
        $totalTahunIni = Kejadian::whereYear('tanggal_kejadian', $selectedTahun)->count();
        $totalDalamPenanganan = Kejadian::where('status', 'Dalam Penanganan')->count();

        // Metrik Dampak Bencana Ala DIBI BNPB (Periode Terpilih)
        $totalMeninggal = (clone $baseQuery)->sum('korban_meninggal');
        $totalLuka = (clone $baseQuery)->sum('korban_luka');
        $totalKK = (clone $baseQuery)->sum('kk_terdampak');
        $totalJiwa = (clone $baseQuery)->sum('jiwa_terdampak');
        $totalLuasKarhutla = (clone $baseQuery)->sum('luas_terbakar_ha');
        $totalPersonelTRC = (clone $baseQuery)->sum('jumlah_personel');

        // 2. Data Grafik Batang: Jumlah Kejadian Per Kecamatan (Diurutkan Terbanyak)
        $kecamatanData = Kecamatan::withCount(['kejadian' => function ($q) use ($selectedTahun, $selectedBulan) {
            $q->whereYear('tanggal_kejadian', $selectedTahun);
            if ($selectedBulan && $selectedBulan !== 'semua') {
                $q->whereMonth('tanggal_kejadian', (int) $selectedBulan);
            }
        }])
        ->orderByDesc('kejadian_count')
        ->get();

        $barKecamatanLabels = $kecamatanData->pluck('nama_kecamatan')->toArray();
        $barKecamatanCounts = $kecamatanData->pluck('kejadian_count')->toArray();

        // 3. Data Grafik Garis: Tren Kejadian Per Bulan (Jan - Des pada tahun terpilih)
        $namaBulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $lineTrenPerBulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $lineTrenPerBulan[] = Kejadian::whereYear('tanggal_kejadian', $selectedTahun)
                ->whereMonth('tanggal_kejadian', $m)
                ->count();
        }

        // 4. Data Grafik Donut: Komposisi Jenis Kejadian
        $jenisData = JenisKejadian::withCount(['kejadian' => function ($q) use ($selectedTahun, $selectedBulan) {
            $q->whereYear('tanggal_kejadian', $selectedTahun);
            if ($selectedBulan && $selectedBulan !== 'semua') {
                $q->whereMonth('tanggal_kejadian', (int) $selectedBulan);
            }
        }])
        ->get();

        $donutJenisLabels = [];
        $donutJenisCounts = [];
        $donutJenisColors = [];

        foreach ($jenisData as $item) {
            if ($item->kejadian_count > 0) {
                $donutJenisLabels[] = $item->nama;
                $donutJenisCounts[] = $item->kejadian_count;
                $donutJenisColors[] = $item->warna ?? '#EA580C';
            }
        }

        // 5. Data Peta Sebaran Titik Kejadian Geoportal (Leaflet)
        $mapPoints = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'foto'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereYear('tanggal_kejadian', $selectedTahun)
            ->when($selectedBulan && $selectedBulan !== 'semua', function ($q) use ($selectedBulan) {
                $q->whereMonth('tanggal_kejadian', (int) $selectedBulan);
            })
            ->latest('tanggal_kejadian')
            ->get()
            ->map(function ($k) {
                $fotoFirst = $k->foto->first();
                return [
                    'id' => $k->id,
                    'nomor' => $k->nomor_laporan,
                    'jenis' => $k->jenisKejadian->nama,
                    'jenis_id' => $k->jenis_kejadian_id,
                    'warna' => $k->jenisKejadian->warna ?? '#EA580C',
                    'lat' => (float) $k->latitude,
                    'lng' => (float) $k->longitude,
                    'lokasi' => $k->lokasi_detail,
                    'kecamatan' => $k->kecamatan->nama_kecamatan,
                    'kelurahan' => $k->kelurahan->nama_kelurahan ?? '-',
                    'tanggal' => $k->tanggal_kejadian->format('d/m/Y'),
                    'jam' => substr($k->jam_kejadian, 0, 5),
                    'status' => $k->status,
                    'korban_meninggal' => $k->korban_meninggal,
                    'korban_luka' => $k->korban_luka,
                    'kk_terdampak' => $k->kk_terdampak,
                    'luas_terbakar_ha' => $k->luas_terbakar_ha,
                    'detail_hewan' => $k->detail_hewan,
                    'foto_url' => $fotoFirst ? asset('storage/' . $fotoFirst->file_path) : null,
                    'url' => route('kejadian.show', $k->id),
                ];
            });

        // 6. Data Kejadian Terbaru (5 Terakhir)
        $kejadianTerbaru = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan'])
            ->latest('tanggal_kejadian')
            ->latest('jam_kejadian')
            ->take(6)
            ->get();

        // 7. Tahun Tersedia untuk Filter
        $tahunTersedia = range($now->year - 2, $now->year + 1);

        // 8. Seluruh Jenis Kejadian untuk Filter Layer Peta
        $semuaJenisKejadian = JenisKejadian::all();

        return view('dashboard', compact(
            'totalHariIni',
            'totalBulanIni',
            'totalTahunIni',
            'totalDalamPenanganan',
            'totalMeninggal',
            'totalLuka',
            'totalKK',
            'totalJiwa',
            'totalLuasKarhutla',
            'totalPersonelTRC',
            'selectedTahun',
            'selectedBulan',
            'barKecamatanLabels',
            'barKecamatanCounts',
            'namaBulanSingkat',
            'lineTrenPerBulan',
            'donutJenisLabels',
            'donutJenisCounts',
            'donutJenisColors',
            'mapPoints',
            'kejadianTerbaru',
            'tahunTersedia',
            'semuaJenisKejadian'
        ));
    }

    public function welcome()
    {
        $pengaturan = PengaturanInstansi::getPengaturan();
        $totalKejadian = Kejadian::count();
        $totalDalamPenanganan = Kejadian::where('status', 'Dalam Penanganan')->count();
        $totalSelesai = Kejadian::where('status', 'Selesai')->count();
        
        $totalKarhutla = Kejadian::whereHas('jenisKejadian', function ($q) {
            $q->where('nama', 'like', '%Kebakaran%')->orWhere('nama', 'like', '%Karhutla%');
        })->count();
        
        $totalBanjir = Kejadian::whereHas('jenisKejadian', function ($q) {
            $q->where('nama', 'like', '%Banjir%');
        })->count();

        $totalLuasKarhutla = (float) Kejadian::sum('luas_terbakar_ha');
        $totalJiwaTerdampak = (int) Kejadian::sum('jiwa_terdampak');
        $totalPersonelTRC = (int) Kejadian::sum('jumlah_personel');

        $kejadianTerbaru = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'foto'])
            ->latest('tanggal_kejadian')
            ->latest('jam_kejadian')
            ->take(6)
            ->get();

        $mapPoints = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'foto'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest('tanggal_kejadian')
            ->take(30)
            ->get()
            ->map(function ($k) {
                $fotoFirst = $k->foto->first();
                return [
                    'id' => $k->id,
                    'nomor' => $k->nomor_laporan,
                    'jenis' => $k->jenisKejadian ? $k->jenisKejadian->nama : 'Bencana',
                    'warna' => $k->jenisKejadian ? ($k->jenisKejadian->warna ?? '#EA580C') : '#EA580C',
                    'tanggal' => Carbon::parse($k->tanggal_kejadian)->locale('id')->isoFormat('D MMM Y'),
                    'jam' => $k->jam_kejadian ? substr($k->jam_kejadian, 0, 5) . ' WIB' : '-',
                    'kecamatan' => $k->kecamatan ? $k->kecamatan->nama_kecamatan : '-',
                    'kelurahan' => $k->kelurahan ? $k->kelurahan->nama_kelurahan : '-',
                    'lokasi' => $k->lokasi_detail,
                    'lat' => (float) $k->latitude,
                    'lng' => (float) $k->longitude,
                    'status' => $k->status,
                    'luas_ha' => $k->luas_terbakar_ha ? (float) $k->luas_terbakar_ha : 0,
                    'jiwa' => (int) $k->jiwa_terdampak,
                    'personel' => (int) $k->jumlah_personel,
                    'foto_url' => $fotoFirst ? asset('storage/' . $fotoFirst->path_foto) : null,
                ];
            });

        $semuaJenisKejadian = JenisKejadian::all();

        return view('welcome', compact(
            'pengaturan',
            'totalKejadian',
            'totalDalamPenanganan',
            'totalSelesai',
            'totalKarhutla',
            'totalBanjir',
            'totalLuasKarhutla',
            'totalJiwaTerdampak',
            'totalPersonelTRC',
            'kejadianTerbaru',
            'mapPoints',
            'semuaJenisKejadian'
        ));
    }
}
