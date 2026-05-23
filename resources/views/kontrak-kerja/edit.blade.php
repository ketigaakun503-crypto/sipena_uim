@extends('layouts.app')
@section('title', 'Edit Kontrak')
@section('header', 'Edit Kontrak Kerja')

@section('content')
<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('kontrak-kerja.update', $kontrak->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div class="bg-gray-50 rounded-lg px-4 py-3 text-sm text-gray-600">
            Pegawai: <span class="font-semibold text-gray-800">{{ $kontrak->pegawai->nama_lengkap }}</span>
            &bull; Nomor: <span class="font-mono">{{ $kontrak->nomor_kontrak }}</span>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kontrak <span class="text-red-500">*</span></label>
            <select name="jenis_kontrak" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="tetap" {{ old('jenis_kontrak', $kontrak->jenis_kontrak) === 'tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="tidak_tetap" {{ old('jenis_kontrak', $kontrak->jenis_kontrak) === 'tidak_tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                <option value="paruh_waktu" {{ old('jenis_kontrak', $kontrak->jenis_kontrak) === 'paruh_waktu' ? 'selected' : '' }}>Paruh Waktu</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kontrak->tanggal_mulai->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kontrak->tanggal_selesai?->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="aktif" {{ old('status', $kontrak->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="diperpanjang" {{ old('status', $kontrak->status) === 'diperpanjang' ? 'selected' : '' }}>Diperpanjang</option>
                <option value="berakhir" {{ old('status', $kontrak->status) === 'berakhir' ? 'selected' : '' }}>Berakhir</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <textarea name="keterangan" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">{{ old('keterangan', $kontrak->keterangan) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-[#1E3A5F] text-white px-6 py-2 rounded-lg hover:bg-[#16304f] text-sm font-medium">Update</button>
            <a href="{{ route('kontrak-kerja.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection