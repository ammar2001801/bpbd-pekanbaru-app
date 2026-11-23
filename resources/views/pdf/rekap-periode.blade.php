<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Bencana - {{ $periodeJudul }}</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
            size: a4 landscape;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5pt;
            line-height: 1.3;
            color: #111111;
        }
        /* KOP SURAT RESMI PEMKOT & BPBD (LANDSCAPE) */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .kop-table td {
            text-align: center;
            vertical-align: middle;
        }
        .kop-pemda {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            padding: 0;
        }
        .kop-instansi {
            font-size: 14pt;
            font-weight: 900;
            text-transform: uppercase;
            color: #0F172A;
            margin: 2px 0;
            padding: 0;
        }
        .kop-pusdalops {
            font-size: 9.5pt;
            font-weight: bold;
            color: #EA580C;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 2px 0;
        }
        .kop-alamat {
            font-size: 8pt;
            color: #334155;
            margin: 0;
        }
        .kop-line {
            border-top: 2px solid #000000;
            border-bottom: 1px solid #000000;
            height: 2px;
            margin-top: 4px;
            margin-bottom: 12px;
        }
        /* JUDUL DOKUMEN */
        .judul-doc {
            text-align: center;
            margin-bottom: 12px;
        }
        .judul-text {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .periode-text {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0F172A;
            margin-top: 2px;
        }
        /* RINGKASAN REKAPITULASI */
        .summary-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .summary-box td {
            border: 1px solid #94a3b8;
            padding: 4px 6px;
            text-align: center;
            font-size: 8pt;
            background-color: #f8fafc;
        }
        .summary-label {
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            font-size: 7.5pt;
        }
        .summary-val {
            font-size: 11pt;
            font-weight: 900;
            color: #0F172A;
            margin-top: 1px;
        }
        /* TABEL UTAMA */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .table-data th {
            background-color: #1E3A8A;
            color: #ffffff;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 4px;
            border: 1px solid #0F172A;
            text-align: center;
        }
        .table-data td {
            border: 1px solid #cbd5e1;
            padding: 4px 5px;
            font-size: 8pt;
            vertical-align: top;
        }
        .table-data tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        /* BADGE STATUS */
        .badge {
            display: inline-block;
            padding: 2px 4px;
            font-size: 7pt;
            font-weight: bold;
            border-radius: 2px;
            text-transform: uppercase;
        }
        .badge-selesai {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .badge-proses {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        /* BLOK TANDA TANGAN */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .space-ttd {
            height: 50px;
        }
        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }
        .nip-pejabat {
            font-size: 8pt;
            color: #334155;
        }
    </style>
</head>
<body>
@if(!empty($isPrintFallback))
    <div style="background: #0f172a; color: white; padding: 12px 20px; font-family: Arial, sans-serif; font-size: 13px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 9999; margin-bottom: 20px; border-bottom: 2px solid #ea580c;" class="no-print">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="background: #ea580c; color: white; padding: 3px 8px; border-radius: 6px; font-weight: bold; font-size: 11px;">DOKUMEN RESMI SIAP CETAK</span>
            <span>Versi cetak resmi peramban aktif. Anda dapat langsung mencetak atau menyimpan dokumen ini sebagai file PDF (Ctrl+P).</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" style="background: #ea580c; color: white; border: none; padding: 7px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">Cetak / Simpan PDF</button>
            <button onclick="window.history.back()" style="background: #334155; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer;">Kembali</button>
        </div>
    </div>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
@endif

    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td style="width: 10%; text-align: center; vertical-align: middle;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="width: 65px; height: 65px; object-fit: contain;" />
                @else
                    <div style="font-weight: bold; font-size: 13pt; color: #EA580C; border: 2px solid #EA580C; padding: 8px; border-radius: 50%;">BPBD</div>
                @endif
            </td>
            <td style="width: 90%;">
                <div class="kop-pemda">{{ strtoupper($pengaturan->nama_pemda ?? 'PEMERINTAH KOTA PEKANBARU') }}</div>
                <div class="kop-instansi">{{ strtoupper($pengaturan->nama_instansi ?? 'BADAN PENANGGULANGAN BENCANA DAERAH') }}</div>
                <div class="kop-pusdalops">Pusat Pengendalian Operasi Penanggulangan Bencana (PUSDALOPS-PB)</div>
                <div class="kop-alamat">{{ $pengaturan->alamat ?? 'Jl. Mustafa Sari No. 1, Kec. Bukit Raya, Kota Pekanbaru, Riau 28126' }} &bull; Kontak: {{ $pengaturan->kontak ?? 'Call Center 112 / 0811-7604-800' }} &bull; Email: {{ $pengaturan->email ?? 'bpbd@pekanbaru.go.id' }}</div>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="judul-doc">
        <div class="judul-text">LAPORAN REKAPITULASI KEJADIAN BENCANA & KEDARURATAN</div>
        <div class="periode-text">PERIODE: {{ strtoupper($periodeJudul) }}</div>
    </div>

    <!-- RINGKASAN DATA KUNCI -->
    <table class="summary-box">
        <tr>
            <td style="width: 16%;">
                <div class="summary-label">Total Kejadian</div>
                <div class="summary-val">{{ $totalKejadian }}</div>
            </td>
            <td style="width: 16%;">
                <div class="summary-label">Korban Meninggal</div>
                <div class="summary-val" style="color: #dc2626;">{{ $totalMeninggal }} <span style="font-size: 8pt; font-weight: normal;">Jiwa</span></div>
            </td>
            <td style="width: 16%;">
                <div class="summary-label">Korban Luka</div>
                <div class="summary-val" style="color: #ea580c;">{{ $totalLuka }} <span style="font-size: 8pt; font-weight: normal;">Jiwa</span></div>
            </td>
            <td style="width: 16%;">
                <div class="summary-label">KK Terdampak</div>
                <div class="summary-val">{{ $totalKK }} <span style="font-size: 8pt; font-weight: normal;">KK</span></div>
            </td>
            <td style="width: 16%;">
                <div class="summary-label">Jiwa Terdampak</div>
                <div class="summary-val">{{ $totalJiwa }} <span style="font-size: 8pt; font-weight: normal;">Jiwa</span></div>
            </td>
            <td style="width: 20%;">
                <div class="summary-label">Total Karhutla</div>
                <div class="summary-val" style="color: #c2410c;">{{ number_format($totalHa, 2) }} <span style="font-size: 8pt; font-weight: normal;">Ha</span></div>
            </td>
        </tr>
    </table>

    <!-- TABEL DATA REKAPITULASI -->
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 12%;">No. Laporan</th>
                <th style="width: 11%;">Waktu Kejadian</th>
                <th style="width: 12%;">Jenis Bencana</th>
                <th style="width: 18%;">Lokasi (Kecamatan / Kelurahan / TKP)</th>
                <th style="width: 16%;">Dampak & Kerusakan</th>
                <th style="width: 11%;">Personel / TRC</th>
                <th style="width: 9%;">Pelapor</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarKejadian as $index => $item)
                <tr>
                    <td class="text-center font-bold">{{ $index + 1 }}</td>
                    <td class="font-bold text-center" style="font-size: 7.5pt;">{{ $item->nomor_laporan }}</td>
                    <td>
                        {{ $item->tanggal_kejadian->format('d/m/Y') }}<br>
                        <span style="color: #475569; font-size: 7.5pt;">Pkl. {{ substr($item->jam_kejadian, 0, 5) }} WIB</span>
                    </td>
                    <td>
                        <strong>{{ $item->jenisKejadian->nama }}</strong>
                    </td>
                    <td>
                        <strong>Kec. {{ $item->kecamatan->nama_kecamatan }}</strong><br>
                        <span style="color: #334155;">{{ $item->kelurahan ? 'Kel. ' . $item->kelurahan->nama_kelurahan . ', ' : '' }}{{ $item->lokasi_detail }}</span>
                    </td>
                    <td>
                        @if($item->korban_meninggal > 0 || $item->korban_luka > 0)
                            <span style="color: #b91c1c; font-weight: bold;">
                                MD: {{ $item->korban_meninggal }}, Luka: {{ $item->korban_luka }}
                            </span><br>
                        @endif
                        @if($item->kk_terdampak > 0 || $item->jiwa_terdampak > 0)
                            <span>Terdampak: {{ $item->kk_terdampak }} KK / {{ $item->jiwa_terdampak }} Jiwa</span><br>
                        @endif
                        @if($item->luas_terbakar_ha > 0)
                            <span style="color: #c2410c; font-weight: bold;">Luas: {{ number_format($item->luas_terbakar_ha, 2) }} Ha</span><br>
                        @endif
                        @if($item->detail_hewan)
                            <span style="color: #0f766e;">Satwa: {{ $item->detail_hewan }}</span><br>
                        @endif
                        @if($item->kerusakan_fasilitas)
                            <span style="font-size: 7pt; color: #64748b;">{{ \Illuminate\Support\Str::limit($item->kerusakan_fasilitas, 40) }}</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->jumlah_personel }} Orang TRC</strong>
                    </td>
                    <td>
                        {{ $item->sumber_informasi ?? 'Call Center 112' }}
                    </td>
                    <td class="text-center">
                        @if($item->status === 'Selesai')
                            <span class="badge badge-selesai">Selesai</span>
                        @else
                            <span class="badge badge-proses">Proses</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 15px; color: #64748b; font-style: italic;">
                        Tidak ada catatan kejadian bencana pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($daftarKejadian->count() > 0)
        <tfoot>
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td colspan="5" class="text-right" style="padding-right: 10px;">TOTAL KESELURUHAN:</td>
                <td colspan="4">
                    {{ $totalKejadian }} Kejadian | 
                    MD: {{ $totalMeninggal }} | 
                    Luka: {{ $totalLuka }} | 
                    KK: {{ $totalKK }} | 
                    Jiwa: {{ $totalJiwa }} | 
                    Karhutla: {{ number_format($totalHa, 2) }} Ha
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- BLOK TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td>
                Dibuat Oleh,<br>
                Petugas Operator Pusdalops-PB<br>
                <div class="space-ttd"></div>
                <span class="nama-pejabat">{{ auth()->user()->name ?? 'Petugas Pusdalops' }}</span><br>
                <span class="nip-pejabat">{{ auth()->user()->jabatan ?? 'Petugas TRC BPBD Kota Pekanbaru' }}</span>
            </td>
            <td>
                Pekanbaru, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>
                Mengetahui,<br>
                <strong>{{ $pengaturan->jabatan_pimpinan ?? 'Kepala Pelaksana BPBD Kota Pekanbaru' }}</strong><br>
                <div class="space-ttd"></div>
                <span class="nama-pejabat">{{ $pengaturan->nama_pimpinan ?? 'Zarman Candra, S.STP, M.Si' }}</span><br>
                <span class="nip-pejabat">NIP. {{ $pengaturan->nip_pimpinan ?? '19750510 199402 1 001' }}</span>
            </td>
        </tr>
    </table>

</body>
</html>