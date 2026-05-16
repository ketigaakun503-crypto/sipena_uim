<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\PengajuanLembur;
use App\Models\SuratJafa;
use App\Models\SuratSerdos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{
    // ── Laporan Pegawai ──────────────────────────────────────────────────────
    public function pegawai(Request $request)
    {
        $query = Pegawai::with(['jabatanAktif.unitKerja']);

        if ($request->jenis_pegawai) {
            $query->where('jenis_pegawai', $request->jenis_pegawai);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pegawais = $query->orderBy('nama_lengkap')->get();
        return view('laporan.pegawai', compact('pegawais'));
    }

    public function pegawaiPdf(Request $request)
    {
        $query = Pegawai::with(['jabatanAktif.unitKerja']);
        if ($request->jenis_pegawai) $query->where('jenis_pegawai', $request->jenis_pegawai);
        if ($request->status) $query->where('status', $request->status);
        $pegawais = $query->orderBy('nama_lengkap')->get();

        $pdf = Pdf::loadView('laporan.pdf.pegawai', compact('pegawais'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-pegawai-' . now()->format('Ymd') . '.pdf');
    }

    public function pegawaiExcel(Request $request)
    {
        $query = Pegawai::with(['jabatanAktif.unitKerja']);
        if ($request->jenis_pegawai) $query->where('jenis_pegawai', $request->jenis_pegawai);
        if ($request->status) $query->where('status', $request->status);
        $pegawais = $query->orderBy('nama_lengkap')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pegawai');

        // Header
        $headers = ['No', 'Nama Lengkap', 'NIP', 'NIDN', 'Jenis Pegawai', 'Jabatan Aktif', 'Status'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValue(chr(65 + $i) . '1', $h);
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }

        // Style header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('1E3A5F');
        $sheet->getStyle('A1:G1')->getFont()->getColor()->setRGB('FFFFFF');

        // Data
        foreach ($pegawais as $i => $p) {
            $row = $i + 2;
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $p->nama_lengkap);
            $sheet->setCellValue('C' . $row, $p->nip ?? '-');
            $sheet->setCellValue('D' . $row, $p->nidn ?? '-');
            $sheet->setCellValue('E' . $row, ucfirst($p->jenis_pegawai));
            $sheet->setCellValue('F' . $row, $p->jabatanAktif->pluck('nama')->implode(', ') ?: '-');
            $sheet->setCellValue('G' . $row, ucfirst($p->status));
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-pegawai-' . now()->format('Ymd') . '.xlsx';
        $path = storage_path('app/public/' . $filename);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    // ── Laporan Cuti ─────────────────────────────────────────────────────────
    public function cuti(Request $request)
    {
        $query = PengajuanCuti::with('pegawai');

        if ($request->bulan) $query->whereMonth('tanggal_mulai', $request->bulan);
        if ($request->tahun) $query->whereYear('tanggal_mulai', $request->tahun);
        if ($request->status) $query->where('status', $request->status);

        $pengajuan = $query->latest()->get();
        return view('laporan.cuti', compact('pengajuan'));
    }

    public function cutiPdf(Request $request)
    {
        $query = PengajuanCuti::with('pegawai');
        if ($request->bulan) $query->whereMonth('tanggal_mulai', $request->bulan);
        if ($request->tahun) $query->whereYear('tanggal_mulai', $request->tahun);
        $pengajuan = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.pdf.cuti', compact('pengajuan'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-cuti-' . now()->format('Ymd') . '.pdf');
    }

    public function cutiExcel(Request $request)
    {
        $query = PengajuanCuti::with('pegawai');
        if ($request->bulan) $query->whereMonth('tanggal_mulai', $request->bulan);
        if ($request->tahun) $query->whereYear('tanggal_mulai', $request->tahun);
        $pengajuan = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Cuti');

        $headers = ['No', 'Nama Pegawai', 'Jenis Cuti', 'Tanggal Mulai', 'Tanggal Selesai', 'Jumlah Hari', 'Status'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValue(chr(65 + $i) . '1', $h);
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('1E3A5F');
        $sheet->getStyle('A1:G1')->getFont()->getColor()->setRGB('FFFFFF');

        foreach ($pengajuan as $i => $p) {
            $row = $i + 2;
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $p->pegawai->nama_lengkap);
            $sheet->setCellValue('C' . $row, ucwords(str_replace('_', ' ', $p->jenis_cuti)));
            $sheet->setCellValue('D' . $row, $p->tanggal_mulai->format('d/m/Y'));
            $sheet->setCellValue('E' . $row, $p->tanggal_selesai->format('d/m/Y'));
            $sheet->setCellValue('F' . $row, $p->jumlah_hari . ' hari');
            $sheet->setCellValue('G' . $row, ucfirst($p->status));
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-cuti-' . now()->format('Ymd') . '.xlsx';
        $path = storage_path('app/public/' . $filename);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    // ── Laporan Lembur ────────────────────────────────────────────────────────
    public function lembur(Request $request)
    {
        $query = PengajuanLembur::with('pegawai');
        if ($request->bulan) $query->whereMonth('tanggal_lembur', $request->bulan);
        if ($request->tahun) $query->whereYear('tanggal_lembur', $request->tahun);
        if ($request->status) $query->where('status', $request->status);
        $pengajuan = $query->latest()->get();
        return view('laporan.lembur', compact('pengajuan'));
    }

    public function lemburPdf(Request $request)
    {
        $query = PengajuanLembur::with('pegawai');
        if ($request->bulan) $query->whereMonth('tanggal_lembur', $request->bulan);
        if ($request->tahun) $query->whereYear('tanggal_lembur', $request->tahun);
        $pengajuan = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.pdf.lembur', compact('pengajuan'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-lembur-' . now()->format('Ymd') . '.pdf');
    }

    // ── Laporan Jafa/Serdos ───────────────────────────────────────────────────
    public function jafaSerdos()
    {
        $jafas   = SuratJafa::with('pegawai')->latest()->get();
        $serdos  = SuratSerdos::with('pegawai')->latest()->get();
        return view('laporan.jafa-serdos', compact('jafas', 'serdos'));
    }
}