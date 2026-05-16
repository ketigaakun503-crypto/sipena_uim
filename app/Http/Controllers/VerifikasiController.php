<?php

namespace App\Http\Controllers;

use App\Models\SuratJafa;
use App\Models\SuratSerdos;
use App\Services\JafaService;
use App\Services\SerdosService;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function __construct(
        protected JafaService $jafaService,
        protected SerdosService $serdosService,
        protected NotifikasiService $notifikasiService,
    ) {}

    public function index()
    {
        $jafas  = SuratJafa::with('pegawai')->whereIn('status', ['diajukan'])->latest()->get();
        $serdos = SuratSerdos::with('pegawai')->whereIn('status', ['diajukan'])->latest()->get();
        return view('verifikasi.index', compact('jafas', 'serdos'));
    }

    public function prosesJafa(Request $request, int $id)
    {
        $request->validate([
            'status'  => 'required|in:diverifikasi,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $this->jafaService->verifikasi($id, $request->status, $request->catatan);

        $jafa = SuratJafa::with('pegawai')->findOrFail($id);
        $this->notifikasiService->kirim(
            $jafa->pegawai->user_id,
            $request->status === 'diverifikasi' ? 'Surat Jafa Diverifikasi' : 'Surat Jafa Ditolak',
            $request->status === 'diverifikasi'
                ? "Surat Jafa Anda ({$jafa->nomor_surat}) telah diverifikasi oleh Admin SDM."
                : "Surat Jafa Anda ({$jafa->nomor_surat}) ditolak. Catatan: {$request->catatan}",
            $request->status === 'diverifikasi' ? 'success' : 'error',
        );

        return back()->with('success', 'Berkas Jafa berhasil diproses.');
    }

    public function prosesSerdos(Request $request, int $id)
    {
        $request->validate([
            'status'  => 'required|in:diverifikasi,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $this->serdosService->verifikasi($id, $request->status, $request->catatan);

        $serdos = SuratSerdos::with('pegawai')->findOrFail($id);
        $this->notifikasiService->kirim(
            $serdos->pegawai->user_id,
            $request->status === 'diverifikasi' ? 'Surat Serdos Diverifikasi' : 'Surat Serdos Ditolak',
            $request->status === 'diverifikasi'
                ? "Surat Serdos Anda ({$serdos->nomor_surat}) telah diverifikasi oleh Admin SDM."
                : "Surat Serdos Anda ({$serdos->nomor_surat}) ditolak. Catatan: {$request->catatan}",
            $request->status === 'diverifikasi' ? 'success' : 'error',
        );

        return back()->with('success', 'Berkas Serdos berhasil diproses.');
    }
}