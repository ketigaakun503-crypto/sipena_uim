<?php

namespace App\Http\Controllers;

use App\Services\UnitKerjaService;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function __construct(protected UnitKerjaService $unitKerjaService) {}

    public function index()
    {
        $unitKerjas = $this->unitKerjaService->getAll();
        return view('unit-kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        $parents = $this->unitKerjaService->getAll();
        return view('unit-kerja.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'jenis'     => 'required|in:fakultas,prodi,biro,lembaga',
            'parent_id' => 'nullable|exists:unit_kerjas,id',
        ]);

        $this->unitKerjaService->create($request->only('nama', 'jenis', 'parent_id'));
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $unitKerja = $this->unitKerjaService->findById($id);
        $parents   = $this->unitKerjaService->getAll();
        return view('unit-kerja.edit', compact('unitKerja', 'parents'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'jenis'     => 'required|in:fakultas,prodi,biro,lembaga',
            'parent_id' => 'nullable|exists:unit_kerjas,id',
        ]);

        $this->unitKerjaService->update($id, $request->only('nama', 'jenis', 'parent_id'));
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->unitKerjaService->delete($id);
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil dihapus.');
    }
}