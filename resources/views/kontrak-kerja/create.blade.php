@extends('layouts.app')
@section('title', 'Tambah Kontrak Kerja')
@section('header', 'Tambah Kontrak Kerja')

@section('content')
<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('kontrak-kerja.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pegawai <span class="text-red-500">*</span></label>
            <select name="pegawai_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawais as $p)
                    <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_lengkap }} ({{ $p->nip ?? $p->nidn ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('pegawai_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontrak <span class="text-red-500">*</span></label>
            <input type="text" name="nomor_kontrak" value="{{ old('nomor_kontrak') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                placeholder="Contoh: KK/001/SDM/V/2026">
            @error('nomor_kontrak')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kontrak <span class="text-red-500">*</span></label>
            <select name="jenis_kontrak" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="">-- Pilih Jenis --</option>
                <option value="tetap" {{ old('jenis_kontrak') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="tidak_tetap" {{ old('jenis_kontrak') === 'tidak_tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                <option value="paruh_waktu" {{ old('jenis_kontrak') === 'paruh_waktu' ? 'selected' : '' }}>Paruh Waktu</option>
            </select>
            @error('jenis_kontrak')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                @error('tanggal_mulai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-gray-400 font-normal">(kosongkan jika tetap)</span></label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                @error('tanggal_selesai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <textarea name="keterangan" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-[#1E3A5F] text-white px-6 py-2 rounded-lg hover:bg-[#16304f] text-sm font-medium">Simpan</button>
            <a href="{{ route('kontrak-kerja.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection