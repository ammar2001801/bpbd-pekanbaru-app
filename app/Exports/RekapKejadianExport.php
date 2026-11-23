<?php

namespace App\Exports;

use App\Models\PengaturanInstansi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapKejadianExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithCustomStartCell
{
    protected $kejadian;
    protected $periodeJudul;
    protected $pengaturan;
    protected $rowNumber = 0;

    public function __construct($kejadian, string $periodeJudul)
    {
        $this->kejadian = $kejadian;
        $this->periodeJudul = $periodeJudul;
        $this->pengaturan = PengaturanInstansi::getPengaturan();
    }

    public function collection(): \Illuminate\Support\Enumerable
    {
        return $this->kejadian;
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function headings(): array
    {
        return [
            'NO',
            'NOMOR LAPORAN',
            'TANGGAL',
            'JAM (WIB)',
            'JENIS BENCANA',
            'KECAMATAN',
            'KELURAHAN',
            'LOKASI DETAIL TKP',
            'KORBAN MENINGGAL',
            'KORBAN LUKA',
            'KK TERDAMPAK',
            'JIWA TERDAMPAK',
            'LUAS KARHUTLA (HA)',
            'SATWA DIEVAKUASI',
            'STATUS',
            'PERSONEL',
            'SUMBER INFORMASI',
        ];
    }

    public function map($item): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $item->nomor_laporan,
            $item->tanggal_kejadian->format('d/m/Y'),
            substr($item->jam_kejadian, 0, 5),
            $item->jenisKejadian->nama ?? '-',
            'Kec. ' . ($item->kecamatan->nama_kecamatan ?? '-'),
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->lokasi_detail,
            $item->korban_meninggal,
            $item->korban_luka,
            $item->kk_terdampak,
            $item->jiwa_terdampak,
            $item->luas_terbakar_ha ? number_format($item->luas_terbakar_ha, 2) : '-',
            $item->detail_hewan ?? '-',
            $item->status,
            $item->jumlah_personel,
            $item->sumber_informasi ?? 'Call Center 112',
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        // 1. Header Instansi Pemerintah
        $sheet->setCellValue('A1', strtoupper($this->pengaturan->nama_pemda ?? 'PEMERINTAH KOTA PEKANBARU'));
        $sheet->mergeCells('A1:Q1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', strtoupper($this->pengaturan->nama_instansi ?? 'BADAN PENANGGULANGAN BENCANA DAERAH'));
        $sheet->mergeCells('A2:Q2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Pusdalops-PB | ' . ($this->pengaturan->alamat ?? 'Jl. Mustafa Sari No. 1 Pekanbaru') . ' | Kontak: ' . ($this->pengaturan->kontak ?? '112'));
        $sheet->mergeCells('A3:Q3');
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(9);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'REKAPITULASI LAPORAN KEJADIAN BENCANA - ' . strtoupper($this->periodeJudul));
        $sheet->mergeCells('A4:Q4');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB('EA580C');
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 2. Format Header Tabel (Row 6)
        $sheet->getStyle('A6:Q6')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);

        $lastRow = 6 + $this->rowNumber;

        // 3. Border untuk data
        if ($this->rowNumber > 0) {
            $sheet->getStyle("A7:Q{$lastRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);

            // Alignment kolom angka & tanggal di tengah
            $sheet->getStyle("A7:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C7:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("I7:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("O7:P{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // 4. Baris Total Keseluruhan
        $totalRow = $lastRow + 1;
        $sheet->setCellValue("A{$totalRow}", 'TOTAL KESELURUHAN (' . $this->rowNumber . ' KEJADIAN):');
        $sheet->mergeCells("A{$totalRow}:H{$totalRow}");
        $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        if ($this->rowNumber > 0) {
            $sheet->setCellValue("I{$totalRow}", "=SUM(I7:I{$lastRow})");
            $sheet->setCellValue("J{$totalRow}", "=SUM(J7:J{$lastRow})");
            $sheet->setCellValue("K{$totalRow}", "=SUM(K7:K{$lastRow})");
            $sheet->setCellValue("L{$totalRow}", "=SUM(L7:L{$lastRow})");
        }

        $sheet->getStyle("A{$totalRow}:Q{$totalRow}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F1F5F9']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle("I{$totalRow}:L{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 5. Tanda Tangan Pimpinan & Petugas
        $ttdRow = $totalRow + 3;
        $sheet->setCellValue("M{$ttdRow}", 'Pekanbaru, ' . \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y'));
        $sheet->mergeCells("M{$ttdRow}:Q{$ttdRow}");
        $sheet->getStyle("M{$ttdRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $ttdRow2 = $ttdRow + 1;
        $sheet->setCellValue("C{$ttdRow2}", 'Dibuat Oleh:');
        $sheet->setCellValue("C" . ($ttdRow2 + 1), 'Petugas Operator Pusdalops-PB');
        $sheet->setCellValue("C" . ($ttdRow2 + 5), 'Petugas Pusdalops');
        $sheet->setCellValue("C" . ($ttdRow2 + 6), 'Staf TRC BPBD Kota Pekanbaru');
        $sheet->getStyle("C" . ($ttdRow2 + 5))->getFont()->setBold(true)->setUnderline(true);

        $sheet->setCellValue("M{$ttdRow2}", 'Mengetahui:');
        $sheet->mergeCells("M{$ttdRow2}:Q{$ttdRow2}");
        $sheet->setCellValue("M" . ($ttdRow2 + 1), $this->pengaturan->jabatan_pimpinan ?? 'Kepala Pelaksana BPBD Kota Pekanbaru');
        $sheet->mergeCells("M" . ($ttdRow2 + 1) . ":Q" . ($ttdRow2 + 1));
        
        $sheet->setCellValue("M" . ($ttdRow2 + 5), $this->pengaturan->nama_pimpinan ?? 'Zarman Candra, S.STP, M.Si');
        $sheet->mergeCells("M" . ($ttdRow2 + 5) . ":Q" . ($ttdRow2 + 5));
        $sheet->getStyle("M" . ($ttdRow2 + 5))->getFont()->setBold(true)->setUnderline(true);

        $sheet->setCellValue("M" . ($ttdRow2 + 6), 'NIP. ' . ($this->pengaturan->nip_pimpinan ?? '19750510 199402 1 001'));
        $sheet->mergeCells("M" . ($ttdRow2 + 6) . ":Q" . ($ttdRow2 + 6));

        $sheet->getStyle("M{$ttdRow2}:Q" . ($ttdRow2 + 6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return null;
    }
}
