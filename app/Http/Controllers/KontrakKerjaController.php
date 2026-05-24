<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Services\KontrakKerjaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KontrakKerjaController extends Controller
{
    public function __construct(protected KontrakKerjaService $kontrakService) {}

    public function index()
    {
        $kontrakList = $this->kontrakService->getAll();
        return view('kontrak-kerja.index', compact('kontrakList'));
    }

    public function create()
    {
        $pegawais = Pegawai::orderBy('nama_lengkap')->get();
        return view('kontrak-kerja.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'      => 'required|exists:pegawais,id',
            'nomor_kontrak'   => 'required|string|unique:kontrak_kerjas,nomor_kontrak',
            'jenis_kontrak'   => 'required|in:tetap,tidak_tetap,paruh_waktu',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'keterangan'      => 'nullable|string',
        ]);

        $this->kontrakService->create($request->all());
        return redirect()->route('kontrak-kerja.index')
            ->with('success', 'Kontrak kerja berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $kontrak = $this->kontrakService->findById($id);
        return view('kontrak-kerja.show', compact('kontrak'));
    }

    public function edit(int $id)
    {
        $kontrak  = $this->kontrakService->findById($id);
        $pegawais = Pegawai::orderBy('nama_lengkap')->get();
        return view('kontrak-kerja.edit', compact('kontrak', 'pegawais'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'jenis_kontrak'   => 'required|in:tetap,tidak_tetap,paruh_waktu',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'status'          => 'required|in:aktif,berakhir,diperpanjang',
            'keterangan'      => 'nullable|string',
        ]);

        $this->kontrakService->update($id, $request->all());
        return redirect()->route('kontrak-kerja.index')
            ->with('success', 'Kontrak kerja berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->kontrakService->delete($id);
        return redirect()->route('kontrak-kerja.index')
            ->with('success', 'Kontrak kerja berhasil dihapus.');
    }

  public function cetakPdf(int $id)
{
    $kontrak = $this->kontrakService->findById($id);
    $pdf     = Pdf::loadView('kontrak-kerja.pdf', compact('kontrak'))
                  ->setPaper('a4', 'portrait');
    
    $nomorFile = str_replace(['/', '\\', ' '], '-', $kontrak->nomor_kontrak);
    
    return $pdf->download("kontrak-{$nomorFile}.pdf");
}

    // Halaman kontrak untuk pegawai sendiri
    public function milik()
    {
        $pegawai     = auth()->user()->pegawai;
        $kontrakList = $this->kontrakService->getByPegawai($pegawai->id);
        return view('kontrak-kerja.milik', compact('kontrakList', 'pegawai'));
    }
}