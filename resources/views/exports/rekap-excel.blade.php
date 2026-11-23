<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table>
    <thead>
        <tr>
            <th colspan="17" style="font-weight: bold; font-size: 14pt; text-align: center;">
                {{ strtoupper($pengaturan->nama_pemda ?? 'PEMERINTAH KOTA PEKANBARU') }}
            </th>
        </tr>
        <tr>
            <th colspan="17" style="font-weight: bold; font-size: 12pt; text-align: center;">
                {{ strtoupper($pengaturan->nama_instansi ?? 'BADAN PENANGGULANGAN BENCANA DAERAH') }}
            </th>
        </tr>
        <tr>
            <th colspan="17" style="font-style: italic; font-size: 10pt; text-align: center;">
                PUSDALOPS-PB &bull; Alamat: {{ $pengaturan->alamat ?? 'Jl. Mustafa Sari No. 1 Pekanbaru' }}
            </th>
        </tr>
        <tr>
            <th colspan="17" style="font-weight: bold; font-size: 11pt; text-align: center; color: #EA580C;">
                REKAPITULASI LAPORAN KEJADIAN BENCANA & KEDARURATAN - {{ strtoupper($periodeJudul) }}
            </th>
        </tr>
        <tr>
            <th colspan="17"></th>
        </tr>
        <tr style="background-color: #1E3A8A; color: #ffffff; font-weight: bold; text-align: center;">
            <th style="border: 1px solid #000000; width: 50px;">No</th>
            <th style="border: 1px solid #000000; width: 180px;">Nomor Laporan</th>
            <th style="border: 1px solid #000000; width: 100px;">Tanggal</th>
            <th style="border: 1px solid #000000; width: 80px;">Jam WIB</th>
            <th style="border: 1px solid #000000; width: 160px;">Jenis Bencana</th>
            <th style="border: 1px solid #000000; width: 140px;">Kecamatan</th>
            <th style="border: 1px solid #000000; width: 140px;">Kelurahan</th>
            <th style="border: 1px solid #000000; width: 280px;">Lokasi / Alamat Detail TKP</th>
            <th style="border: 1px solid #000000; width: 90px;">Meninggal</th>
            <th style="border: 1px solid #000000; width: 80px;">Luka</th>
            <th style="border: 1px solid #000000; width: 80px;">KK</th>
            <th style="border: 1px solid #000000; width: 80px;">Jiwa</th>
            <th style="border: 1px solid #000000; width: 110px;">Luas Karhutla (Ha)</th>
            <th style="border: 1px solid #000000; width: 180px;">Satwa Dievakuasi</th>
            <th style="border: 1px solid #000000; width: 130px;">Status</th>
            <th style="border: 1px solid #000000; width: 90px;">Personel</th>
            <th style="border: 1px solid #000000; width: 160px;">Sumber Informasi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totMeninggal = 0;
            $totLuka = 0;
            $totKK = 0;
            $totJiwa = 0;
            $totHa = 0;
        @endphp
        @forelse($kejadian as $i => $item)
            @php
                $totMeninggal += $item->korban_meninggal;
                $totLuka += $item->korban_luka;
                $totKK += $item->kk_terdampak;
                $totJiwa += $item->jiwa_terdampak;
                $totHa += ($item->luas_terbakar_ha ?? 0);
            @endphp
            <tr>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $i + 1 }}</td>
                <td style="border: 1px solid #cccccc; font-weight: bold;">{{ $item->nomor_laporan }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->tanggal_kejadian->format('d/m/Y') }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ substr($item->jam_kejadian, 0, 5) }}</td>
                <td style="border: 1px solid #cccccc; font-weight: bold;">{{ $item->jenisKejadian->nama ?? '-' }}</td>
                <td style="border: 1px solid #cccccc;">Kec. {{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                <td style="border: 1px solid #cccccc;">{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                <td style="border: 1px solid #cccccc;">{{ $item->lokasi_detail }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->korban_meninggal }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->korban_luka }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->kk_terdampak }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->jiwa_terdampak }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->luas_terbakar_ha ? number_format($item->luas_terbakar_ha, 2) : '-' }}</td>
                <td style="border: 1px solid #cccccc;">{{ $item->detail_hewan ?? '-' }}</td>
                <td style="border: 1px solid #cccccc; text-align: center; font-weight: bold;">{{ $item->status }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->jumlah_personel }}</td>
                <td style="border: 1px solid #cccccc;">{{ $item->sumber_informasi ?? 'Call Center 112' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="17" style="border: 1px solid #cccccc; text-align: center; font-style: italic;">
                    Tidak ada catatan kejadian bencana pada periode ini.
                </td>
            </tr>
        @endforelse

        <tr style="background-color: #f1f5f9; font-weight: bold;">
            <td colspan="8" style="border: 1px solid #000000; text-align: right; padding-right: 10px;">
                TOTAL KESELURUHAN ({{ count($kejadian) }} KEJADIAN):
            </td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $totMeninggal }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $totLuka }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $totKK }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $totJiwa }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $totHa > 0 ? number_format($totHa, 2) . ' Ha' : '-' }}</td>
            <td colspan="4" style="border: 1px solid #000000;"></td>
        </tr>

        <tr><td colspan="17"></td></tr>
        <tr><td colspan="17"></td></tr>

        <tr>
            <td colspan="4"></td>
            <td colspan="5" style="text-align: center; font-size: 10pt;">
                Dibuat Oleh,<br>
                Petugas Operator Pusdalops-PB<br><br><br><br>
                <strong><u>Petugas Pusdalops</u></strong><br>
                Staf TRC BPBD Kota Pekanbaru
            </td>
            <td colspan="3"></td>
            <td colspan="5" style="text-align: center; font-size: 10pt;">
                Pekanbaru, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>
                Mengetahui,<br>
                <strong>{{ $pengaturan->jabatan_pimpinan ?? 'Kepala Pelaksana BPBD Kota Pekanbaru' }}</strong><br><br><br><br>
                <strong><u>{{ $pengaturan->nama_pimpinan ?? 'Zarman Candra, S.STP, M.Si' }}</u></strong><br>
                NIP. {{ $pengaturan->nip_pimpinan ?? '19750510 199402 1 001' }}
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
