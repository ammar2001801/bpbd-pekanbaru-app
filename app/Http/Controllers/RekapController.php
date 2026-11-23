<?php

namespace App\Http\Controllers;

use App\Exports\RekapKejadianExport;
use App\Models\Kejadian;
use App\Models\JenisKejadian;
use App\Models\Kecamatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->input('mode', 'bulanan'); // 'harian', 'bulanan', 'tahunan', 'kustom'
        $now = Carbon::now();

        $tanggalHarian = $request->input('tanggal_harian', $now->toDateString());
        $bulan = (int) $request->input('bulan', $now->month);
        $tahun = (int) $request->input('tahun', $now->year);
        $tanggalMulai = $request->input('tanggal_mulai', $now->copy()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', $now->toDateString());

        // Base Query
        $query = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'user'])
            ->orderBy('tanggal_kejadian')
            ->orderBy('jam_kejadian');

        $periodeJudul = '';

        if ($mode === 'harian') {
            $query->whereDate('tanggal_kejadian', $tanggalHarian);
            $periodeJudul = 'Harian (' . Carbon::parse($tanggalHarian)->locale('id')->isoFormat('D MMMM Y') . ')';
        } elseif ($mode === 'tahunan') {
            $query->whereYear('tanggal_kejadian', $tahun);
            $periodeJudul = "Tahun {$tahun}";
        } elseif ($mode === 'kustom') {
            $query->whereDate('tanggal_kejadian', '>=', $tanggalMulai)
                  ->whereDate('tanggal_kejadian', '<=', $tanggalSelesai);
            $periodeJudul = Carbon::parse($tanggalMulai)->format('d/m/Y') . ' s/d ' . Carbon::parse($tanggalSelesai)->format('d/m/Y');
        } else {
            // Default: bulanan
            $query->whereYear('tanggal_kejadian', $tahun)
                  ->whereMonth('tanggal_kejadian', $bulan);
            $namaBulan = Carbon::create($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM');
            $periodeJudul = "Bulan {$namaBulan} {$tahun}";
        }

        $daftarKejadian = $query->get();

        // 1. Hitung Ringkasan Statistik Agregat
        $totalKejadian = $daftarKejadian->count();
        $totalMeninggal = $daftarKejadian->sum('korban_meninggal');
        $totalLuka = $daftarKejadian->sum('korban_luka');
        $totalKK = $daftarKejadian->sum('kk_terdampak');
        $totalJiwa = $daftarKejadian->sum('jiwa_terdampak');
        $totalLuasKarhutla = $daftarKejadian->sum('luas_terbakar_ha');
        $totalHewan = $daftarKejadian->whereNotNull('detail_hewan')->count();

        // 2. Siapkan Matriks Agregasi (Kecamatan x Jenis Kejadian)
        $semuaKecamatan = Kecamatan::orderBy('nama_kecamatan')->get();
        $semuaJenis = JenisKejadian::orderBy('id')->get();

        // Matrix mapping: $matrix[kecamatan_id][jenis_id] = count
        $matrix = [];
        $totalPerKecamatan = [];
        $totalPerJenis = [];

        foreach ($semuaJenis as $j) {
            $totalPerJenis[$j->id] = 0;
        }

        foreach ($semuaKecamatan as $kec) {
            $totalPerKecamatan[$kec->id] = 0;
            foreach ($semuaJenis as $j) {
                $count = $daftarKejadian->where('kecamatan_id', $kec->id)
                                        ->where('jenis_kejadian_id', $j->id)
                                        ->count();
                $matrix[$kec->id][$j->id] = $count;
                $totalPerKecamatan[$kec->id] += $count;
                $totalPerJenis[$j->id] += $count;
            }
        }

        $tahunTersedia = range($now->year - 2, $now->year + 1);

        return view('rekap.index', compact(
            'mode',
            'tanggalHarian',
            'bulan',
            'tahun',
            'tanggalMulai',
            'tanggalSelesai',
            'periodeJudul',
            'daftarKejadian',
            'totalKejadian',
            'totalMeninggal',
            'totalLuka',
            'totalKK',
            'totalJiwa',
            'totalLuasKarhutla',
            'totalHewan',
            'semuaKecamatan',
            'semuaJenis',
            'matrix',
            'totalPerKecamatan',
            'totalPerJenis',
            'tahunTersedia'
        ));
    }

    public function exportExcel(Request $request)
    {
        $mode = $request->input('mode', 'bulanan');
        $now = Carbon::now();

        $tanggalHarian = $request->input('tanggal_harian', $now->toDateString());
        $bulan = (int) $request->input('bulan', $now->month);
        $tahun = (int) $request->input('tahun', $now->year);
        $tanggalMulai = $request->input('tanggal_mulai', $now->copy()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', $now->toDateString());

        $query = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'user'])
            ->orderBy('tanggal_kejadian')
            ->orderBy('jam_kejadian');

        $periodeJudul = '';
        $slugFile = '';

        if ($mode === 'harian') {
            $query->whereDate('tanggal_kejadian', $tanggalHarian);
            $periodeJudul = 'Harian (' . Carbon::parse($tanggalHarian)->locale('id')->isoFormat('D MMMM Y') . ')';
            $slugFile = "Rekap-Harian-{$tanggalHarian}";
        } elseif ($mode === 'tahunan') {
            $query->whereYear('tanggal_kejadian', $tahun);
            $periodeJudul = "Tahun {$tahun}";
            $slugFile = "Rekap-Tahunan-{$tahun}";
        } elseif ($mode === 'kustom') {
            $query->whereDate('tanggal_kejadian', '>=', $tanggalMulai)
                  ->whereDate('tanggal_kejadian', '<=', $tanggalSelesai);
            $periodeJudul = Carbon::parse($tanggalMulai)->format('d/m/Y') . ' s/d ' . Carbon::parse($tanggalSelesai)->format('d/m/Y');
            $slugFile = "Rekap-Periode-{$tanggalMulai}-sd-{$tanggalSelesai}";
        } else {
            $query->whereYear('tanggal_kejadian', $tahun)
                  ->whereMonth('tanggal_kejadian', $bulan);
            $namaBulan = Carbon::create($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM');
            $periodeJudul = "Bulan {$namaBulan} {$tahun}";
            $slugFile = "Rekap-Bulanan-{$tahun}-{$bulan}";
        }

        $kejadian = $query->get();
        $fileName = "BPBD-Pekanbaru-{$slugFile}.xlsx";

        return Excel::download(new RekapKejadianExport($kejadian, $periodeJudul), $fileName);
    }
}
