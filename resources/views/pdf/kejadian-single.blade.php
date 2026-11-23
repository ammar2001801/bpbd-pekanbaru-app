<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kejadian - {{ $kejadian->nomor_laporan }}</title>
    <style>
        @page {
            margin: 20mm 20mm 20mm 20mm;
            size: a4 portrait;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            line-height: 1.35;
            color: #111111;
        }
        /* KOP SURAT RESMI PEMKOT & BPBD */
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
            font-size: 10pt;
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
            margin-top: 6px;
            margin-bottom: 15px;
        }
        /* JUDUL DOKUMEN */
        .judul-doc {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul-text {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .nomor-text {
            font-size: 9.5pt;
            font-weight: bold;
            color: #333333;
            margin-top: 2px;
        }
        /* TABEL RINCIAN */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .table-data td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 9pt;
        }
        .table-data .label {
            width: 25%;
            font-weight: bold;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
        }
        .table-data .colon {
            width: 2%;
            text-align: center;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1px solid #cbd5e1;
            background-color: #f8fafc;
        }
        .table-data .value {
            border: 1px solid #cbd5e1;
        }
        .section-header {
            background-color: #e2e8f0;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
        }
        /* GALERI FOTO */
        .foto-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 15px;
        }
        .foto-cell {
            width: 50%;
            padding: 5px;
            vertical-align: top;
            text-align: center;
        }
        .foto-img {
            max-width: 95%;
            height: 130px;
            object-fit: cover;
            border: 1px solid #94a3b8;
            padding: 2px;
            background: #ffffff;
        }
        .foto-caption {
            font-size: 8pt;
            color: #475569;
            margin-top: 3px;
            font-style: italic;
        }
        /* BLOK TANDA TANGAN */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 9.5pt;
        }
        .space-ttd {
            height: 55px;
        }
        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }
        .nip-pejabat {
            font-size: 9pt;
            color: #334155;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td style="width: 15%; text-align: center; vertical-align: middle;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="width: 72px; height: 72px; object-fit: contain;" />
                @else
                    <div style="font-weight: bold; font-size: 14pt; color: #EA580C; border: 2px solid #EA580C; padding: 10px; border-radius: 50%;">BPBD</div>
                @endif
            </td>
            <td style="width: 85%;">
                <div class="kop-pemda">{{ strtoupper($pengaturan->nama_pemda ?? 'PEMERINTAH KOTA PEKANBARU') }}</div>
                <div class="kop-instansi">{{ strtoupper($pengaturan->nama_instansi ?? 'BADAN PENANGGULANGAN BENCANA DAERAH') }}</div>
                <div class="kop-pusdalops">Pusat Pengendalian Operasi Penanggulangan Bencana (PUSDALOPS-PB)</div>
                <div class="kop-alamat">{{ $pengaturan->alamat ?? 'Jl. Mustafa Sari No. 1, Kec. Bukit Raya, Kota Pekanbaru, Riau 28126' }}</div>
                <div class="kop-alamat">Kontak: {{ $pengaturan->kontak ?? 'Call Center 112 / 0811-7604-800' }} &bull; Email: {{ $pengaturan->email ?? 'bpbd@pekanbaru.go.id' }}</div>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL LAPORAN -->
    <div class="judul-doc">
        <div class="judul-text">LAPORAN KEJADIAN BENCANA & KEDARURATAN</div>
        <div class="nomor-text">Nomor Registrasi: {{ $kejadian->nomor_laporan }}</div>
    </div>

    <!-- TABEL 1: DATA UMUM KEJADIAN -->
    <table class="table-data">
        <tr>
            <td colspan="3" class="section-header">I. WAKTU & IDENTITAS KEJADIAN</td>
        </tr>
        <tr>
            <td class="label">Hari / Tanggal</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kejadian->tanggal_kejadian->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong></td>
        </tr>
        <tr>
            <td class="label">Jam Kejadian</td>
            <td class="colon">:</td>
            <td class="value">{{ substr($kejadian->jam_kejadian, 0, 5) }} WIB</td>
        </tr>
        <tr>
            <td class="label">Jam Selesai Penanganan</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->jam_selesai ? substr($kejadian->jam_selesai, 0, 5) . ' WIB' : 'Masih dalam penanganan di lapangan' }}</td>
        </tr>
        <tr>
            <td class="label">Klasifikasi Bencana</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kejadian->jenisKejadian->nama }}</strong></td>
        </tr>
        <tr>
            <td class="label">Status Operasi</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kejadian->status }}</strong> ({{ $kejadian->catatan_status ?? 'Situasi terkendali' }})</td>
        </tr>
        <tr>
            <td class="label">Sumber Laporan / Pelapor</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->sumber_informasi ?? 'Masyarakat / Call Center 112' }}</td>
        </tr>

        <!-- BAGIAN II: LOKASI & TITIK KOORDINAT -->
        <tr>
            <td colspan="3" class="section-header">II. LOKASI & TITIK GEOSPASIAL</td>
        </tr>
        <tr>
            <td class="label">Kecamatan</td>
            <td class="colon">:</td>
            <td class="value">Kecamatan {{ $kejadian->kecamatan->nama_kecamatan }}</td>
        </tr>
        <tr>
            <td class="label">Kelurahan</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->kelurahan ? 'Kelurahan ' . $kejadian->kelurahan->nama_kelurahan : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat / Lokasi TKP</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->lokasi_detail }}</td>
        </tr>
        <tr>
            <td class="label">Titik Koordinat GPS</td>
            <td class="colon">:</td>
            <td class="value">Latitude: {{ $kejadian->latitude ?? '-' }}, Longitude: {{ $kejadian->longitude ?? '-' }}</td>
        </tr>

        <!-- BAGIAN III: KRONOLOGI & TINDAKAN -->
        <tr>
            <td colspan="3" class="section-header">III. KRONOLOGI & OPERASI PENANGANAN</td>
        </tr>
        <tr>
            <td class="label">Kronologi Peristiwa</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->kronologi }}</td>
        </tr>
        <tr>
            <td class="label">Tindakan Petugas TRC</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->tindakan }}</td>
        </tr>
        <tr>
            <td class="label">Personel yang Terlibat</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->jumlah_personel }} Orang Personel TRC BPBD Kota Pekanbaru</td>
        </tr>
        <tr>
            <td class="label">Instansi / Mitra Pendukung</td>
            <td class="colon">:</td>
            <td class="value">
                @if($kejadian->instansiPendukung->count() > 0)
                    {{ $kejadian->instansiPendukung->pluck('nama_instansi')->implode(', ') }}
                @else
                    Regu Mandiri TRC BPBD Kota Pekanbaru
                @endif
            </td>
        </tr>

        <!-- BAGIAN IV: DAMPAK KERUSAKAN -->
        <tr>
            <td colspan="3" class="section-header">IV. DAMPAK KORBAN & KERUSAKAN</td>
        </tr>
        <tr>
            <td class="label">Korban Jiwa & Luka</td>
            <td class="colon">:</td>
            <td class="value">Meninggal: <strong>{{ $kejadian->korban_meninggal }}</strong> orang | Luka-Luka: <strong>{{ $kejadian->korban_luka }}</strong> orang</td>
        </tr>
        <tr>
            <td class="label">Masyarakat Terdampak</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kejadian->kk_terdampak }}</strong> Kepala Keluarga (KK) | <strong>{{ $kejadian->jiwa_terdampak }}</strong> Jiwa</td>
        </tr>
        @if($kejadian->luas_terbakar_ha)
        <tr>
            <td class="label">Luas Area Terbakar</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ number_format($kejadian->luas_terbakar_ha, 2) }} Hektare (Ha)</strong></td>
        </tr>
        @endif
        @if($kejadian->detail_hewan)
        <tr>
            <td class="label">Satwa yang Dievakuasi</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kejadian->detail_hewan }}</strong></td>
        </tr>
        @endif
        <tr>
            <td class="label">Kerusakan Fisik / Bangunan</td>
            <td class="colon">:</td>
            <td class="value">{{ $kejadian->kerusakan_fasilitas ?? 'Nihil kerusakan berat' }}</td>
        </tr>
    </table>

    <!-- LAMPIRAN FOTO DOKUMENTASI -->
    @if(count($fotoBase64) > 0)
        <div style="page-break-before: auto; margin-top: 10px;">
            <div class="section-header" style="margin-bottom: 5px;">V. LAMPIRAN DOKUMENTASI LAPANGAN</div>
            <table class="foto-grid">
                @foreach(array_chunk($fotoBase64, 2) as $row)
                    <tr>
                        @foreach($row as $f)
                            <td class="foto-cell">
                                <img src="{{ $f['src'] }}" class="foto-img" />
                                <div class="foto-caption">{{ $f['caption'] }}</div>
                            </td>
                        @endforeach
                        @if(count($row) === 1)
                            <td class="foto-cell"></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <!-- BLOK TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td>
                Dibuat Oleh,<br>
                Petugas Operator Pusdalops-PB<br>
                <div class="space-ttd"></div>
                <span class="nama-pejabat">{{ $kejadian->user->name ?? 'Petugas Pusdalops' }}</span><br>
                <span class="nip-pejabat">{{ $kejadian->user->jabatan ?? 'Petugas TRC BPBD Kota Pekanbaru' }}</span>
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
