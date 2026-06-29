<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use App\Services\CutiService;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function __construct(protected CutiService $cutiService) {}

    public function index()
    {
        $pegawai   = auth()->user()->pegawai;
        $pengajuan = $this->cutiService->getRiwayat($pegawai->id);
        return view('cuti.index', compact('pengajuan', 'pegawai'));
    }

    public function create()
    {
        return view('cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti'      => 'required|in:tahunan,sakit,melahirkan,alasan_penting',
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|string|min:10',
        ]);

        $pegawai = auth()->user()->pegawai;
        $this->cutiService->ajukan($request->all(), $pegawai->id);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dikirim!');
    }

    public function show(int $id)
    {
        $pengajuan = PengajuanCuti::with(['approvals.approver', 'approvals.jabatan'])
            ->findOrFail($id);
        return view('cuti.show', compact('pengajuan'));
    }

    public function batal(int $id)
    {
        $pengajuan = PengajuanCuti::where('pegawai_id', auth()->user()->pegawai->id)
            ->where('id', $id)
            ->where('status', 'menunggu')
            ->firstOrFail();

        $pengajuan->approvals()->delete();
        $pengajuan->delete();

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dibatalkan.');
    }
}