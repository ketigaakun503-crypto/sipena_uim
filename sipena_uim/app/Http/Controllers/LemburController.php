<?php

namespace App\Http\Controllers;

use App\Services\LemburService;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    public function __construct(protected LemburService $lemburService) {}

    public function index()
    {
        $pegawai   = auth()->user()->pegawai;
        $pengajuan = $this->lemburService->getRiwayat($pegawai->id);
        return view('lembur.index', compact('pengajuan', 'pegawai'));
    }

    public function create()
    {
        return view('lembur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_lembur' => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'alasan'         => 'required|string|min:10',
        ]);

        $pegawai = auth()->user()->pegawai;
        $this->lemburService->ajukan($request->all(), $pegawai->id);

        return redirect()->route('lembur.index')->with('success', 'Pengajuan lembur berhasil dikirim!');
    }

    public function show(int $id)
    {
        $pengajuan = \App\Models\PengajuanLembur::with(['approvals.approver'])
            ->findOrFail($id);
        return view('lembur.show', compact('pengajuan'));
    }
}