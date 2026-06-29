<?php

namespace App\Exports;

use App\Models\Pegawai;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PegawaiExport
{
    public function download()
    {
        $pegawais    = Pegawai::with(['jabatanAktif', 'user'])->orderBy('nama_lengkap')->get();
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pegawai');

        // Header
        $headers = ['No', 'Nama Lengkap', 'NIP', 'NIDN', 'Email', 'Jenis Pegawai',
                    'Jenis Kelamin', 'No HP', 'Status', 'Jabatan Aktif', 'Sisa Cuti'];

        foreach ($headers as $i => $h) {
            $col = chr(65 + $i);
            $sheet->setCellValue($col . '1', $h);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Style header
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Data
        foreach ($pegawais as $i => $p) {
            $row = $i + 2;
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $p->nama_lengkap);
            $sheet->setCellValue('C' . $row, $p->nip ?? '-');
            $sheet->setCellValue('D' . $row, $p->nidn ?? '-');
            $sheet->setCellValue('E' . $row, $p->email ?? '-');
            $sheet->setCellValue('F' . $row, ucfirst($p->jenis_pegawai));
            $sheet->setCellValue('G' . $row, $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('H' . $row, $p->no_hp ?? '-');
            $sheet->setCellValue('I' . $row, ucfirst($p->status));
            $sheet->setCellValue('J' . $row, $p->jabatanAktif->pluck('nama')->implode(', ') ?: '-');
            $sheet->setCellValue('K' . $row, $p->sisa_cuti . ' hari');

            // Zebra stripe
            if ($i % 2 === 0) {
                $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F4F8']],
                ]);
            }
        }

        return $spreadsheet;
    }
}