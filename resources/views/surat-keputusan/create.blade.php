@extends('layouts.app')
@section('title', 'Buat SK')
@section('header', 'Buat Surat Keputusan')

@section('content')
<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-5 text-sm">
        ℹ️ Nomor SK akan di-generate otomatis oleh sistem berdasarkan jenis SK dan urutan di tahun berjalan.
    </div>

    <form action="{{ route('surat-keputusan.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pegawai <span class="text-red-500">*</span></label>
            <select name="pegawai_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawais as $p)
                    <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_lengkap }} ({{ $p->nidn ?? $p->nip ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('pegawai_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis SK <span class="text-red-500">*</span></label>
            <select name="jenis_sk" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="">-- Pilih Jenis SK --</option>
                <option value="pengangkatan" {{ old('jenis_sk') === 'pengangkatan' ? 'selected' : '' }}>SK Pengangkatan</option>
                <option value="jabatan_fungsional" {{ old('jenis_sk') === 'jabatan_fungsional' ? 'selected' : '' }}>SK Jabatan Fungsional</option>
                <option value="jabatan_struktural" {{ old('jenis_sk') === 'jabatan_struktural' ? 'selected' : '' }}>SK Jabatan Struktural</option>
            </select>
            @error('jenis_sk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan yang Ditetapkan <span class="text-red-500">*</span></label>
            <input type="text" name="jabatan_yang_ditetapkan" value="{{ old('jabatan_yang_ditetapkan') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                placeholder="Contoh: Dosen Tetap / Lektor / Kaprodi Informatika">
            @error('jabatan_yang_ditetapkan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal SK <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_sk" value="{{ old('tanggal_sk', now()->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                @error('tanggal_sk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">TMT <span class="text-gray-400 font-normal">(Terhitung Mulai Tanggal)</span></label>
                <input type="date" name="tmt" value="{{ old('tmt') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pertimbangan</label>
            <textarea name="pertimbangan" rows="2"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                placeholder="Dasar pertimbangan penerbitan SK...">{{ old('pertimbangan') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <textarea name="keterangan" rows="2"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-[#1E3A5F] text-white px-6 py-2 rounded-lg hover:bg-[#16304f] text-sm font-medium">Buat SK</button>
            <a href="{{ route('surat-keputusan.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection