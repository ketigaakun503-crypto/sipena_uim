<?php

namespace App\Http\Controllers;

use App\Services\JabatanService;
use App\Services\UnitKerjaService;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function __construct(
        protected JabatanService $jabatanService,
        protected UnitKerjaService $unitKerjaService
    ) {}

    public function index()
    {
        $jabatans = $this->jabatanService->getAll();
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        $unitKerjas = $this->unitKerjaService->getAll();
        return view('jabatan.create', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'jenis'        => 'required|in:struktural,akademik,tendik',
            'unit_kerja_id'=> 'required|exists:unit_kerjas,id',
            'level'        => 'required|integer|min:0',
        ]);

        $this->jabatanService->create($request->only('nama', 'jenis', 'unit_kerja_id', 'level'));
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $jabatan    = $this->jabatanService->findById($id);
        $unitKerjas = $this->unitKerjaService->getAll();
        return view('jabatan.edit', compact('jabatan', 'unitKerjas'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'jenis'        => 'required|in:struktural,akademik,tendik',
            'unit_kerja_id'=> 'required|exists:unit_kerjas,id',
            'level'        => 'required|integer|min:0',
        ]);

        $this->jabatanService->update($id, $request->only('nama', 'jenis', 'unit_kerja_id', 'level'));
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->jabatanService->delete($id);
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}