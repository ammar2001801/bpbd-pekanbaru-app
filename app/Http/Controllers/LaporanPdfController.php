<?php

namespace App\Http\Controllers;

use App\Models\Kejadian;
use App\Models\PengaturanInstansi;
use App\Models\Kecamatan;
use App\Models\JenisKejadian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanPdfController extends Controller
{
    /**
     * Halaman Menu / Pusat Cetak Laporan PDF
     */
    public function menu()
    {
        $pengaturan = PengaturanInstansi::getPengaturan();
        $semuaKejadian = Kejadian::latest('tanggal_kejadian')->latest('id')->take(50)->get();
        $tahunTersedia = range(Carbon::now()->year - 2, Carbon::now()->year + 1);

        return view('laporan.pdf-menu', compact('pengaturan', 'semuaKejadian', 'tahunTersedia'));
    }

    /**
     * Cetak PDF Lembar Laporan Kejadian Tunggal (Lengkap dengan Dokumentasi Foto)
     */
    public function singlePdf($id)
    {
        $kejadian = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'instansiPendukung', 'foto', 'user'])->findOrFail($id);
        $pengaturan = PengaturanInstansi::getPengaturan();

        // Siapkan logo instansi dalam format base64
        $logoBase64 = null;
        $logoPath = public_path('images/logo-bpbd.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Siapkan foto-foto dalam format base64 agar DomPDF merender secara instan dan aman
        $fotoBase64 = [];
        foreach ($kejadian->foto as $f) {
            $fullPath = storage_path('app/public/' . $f->file_path);
            if (file_exists($fullPath)) {
                $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
                $data = file_get_contents($fullPath);
                $fotoBase64[] = [
                    'src' => 'data:image/' . $ext . ';base64,' . base64_encode($data),
                    'caption' => $f->caption ?? 'Dokumentasi penanganan di lokasi kejadian',
                ];
            }
        }

        $pdf = Pdf::loadView('pdf.kejadian-single', compact('kejadian', 'pengaturan', 'fotoBase64', 'logoBase64'))
            ->setPaper('A4', 'portrait')
            ->setOption([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 120,
                'defaultFont' => 'sans-serif',
            ]);

        $fileName = 'Laporan-' . str_replace('/', '-', $kejadian->nomor_laporan) . '.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Cetak PDF Rekapitulasi Bencana Berkala (Harian, Bulanan, Tahunan, Kustom)
     */
    public function rekapPdf(Request $request)
    {
        $mode = $request->input('mode', 'bulanan');
        $now = Carbon::now();

        $tanggalHarian = $request->input('tanggal_harian', $now->toDateString());
        $bulan = (int) $request->input('bulan', $now->month);
        $tahun = (int) ($request->input('tahun') ?: $request->input('tahun_only', $now->year));
        if ($mode === 'tahunan' && $request->filled('tahun_only')) {
            $tahun = (int) $request->input('tahun_only');
        }
        $tanggalMulai = $request->input('tanggal_mulai', $now->copy()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', $now->toDateString());

        $query = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'user'])
            ->orderBy('tanggal_kejadian')
            ->orderBy('jam_kejadian');

        $periodeJudul = '';
        $slug = '';

        if ($mode === 'harian') {
            $query->whereDate('tanggal_kejadian', $tanggalHarian);
            $periodeJudul = 'HARIAN (' . Carbon::parse($tanggalHarian)->locale('id')->isoFormat('D MMMM Y') . ')';
            $slug = "Harian-{$tanggalHarian}";
        } elseif ($mode === 'tahunan') {
            $query->whereYear('tanggal_kejadian', $tahun);
            $periodeJudul = "TAHUN {$tahun}";
            $slug = "Tahunan-{$tahun}";
        } elseif ($mode === 'kustom') {
            $query->whereDate('tanggal_kejadian', '>=', $tanggalMulai)
                  ->whereDate('tanggal_kejadian', '<=', $tanggalSelesai);
            $periodeJudul = 'RENTANG ' . Carbon::parse($tanggalMulai)->format('d/m/Y') . ' S/D ' . Carbon::parse($tanggalSelesai)->format('d/m/Y');
            $slug = "Periode-{$tanggalMulai}-sd-{$tanggalSelesai}";
        } else {
            $query->whereYear('tanggal_kejadian', $tahun)
                  ->whereMonth('tanggal_kejadian', $bulan);
            $namaBulan = Carbon::create($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM');
            $periodeJudul = "BULAN " . strtoupper($namaBulan) . " {$tahun}";
            $slug = "Bulanan-{$tahun}-{$bulan}";
        }

        $daftarKejadian = $query->get();
        $pengaturan = PengaturanInstansi::getPengaturan();

        // Agregasi
        $totalKejadian = $daftarKejadian->count();
        $totalMeninggal = $daftarKejadian->sum('korban_meninggal');
        $totalLuka = $daftarKejadian->sum('korban_luka');
        $totalKK = $daftarKejadian->sum('kk_terdampak');
        $totalJiwa = $daftarKejadian->sum('jiwa_terdampak');
        $totalHa = $daftarKejadian->sum('luas_terbakar_ha');

        // Siapkan logo instansi dalam format base64
        $logoBase64 = null;
        $logoPath = public_path('images/logo-bpbd.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('pdf.rekap-periode', compact(
            'daftarKejadian',
            'pengaturan',
            'periodeJudul',
            'totalKejadian',
            'totalMeninggal',
            'totalLuka',
            'totalKK',
            'totalJiwa',
            'totalHa',
            'logoBase64'
        ))
        ->setPaper('A4', 'landscape')
        ->setOption([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 110,
            'defaultFont' => 'sans-serif',
        ]);

        $fileName = "Rekap-Bencana-BPBD-Pekanbaru-{$slug}.pdf";

        return $pdf->stream($fileName);
    }
}
