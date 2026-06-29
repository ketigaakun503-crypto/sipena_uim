@extends('layouts.app')
@section('title', 'Ajukan Cuti')
@section('header', 'Form Pengajuan Cuti')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('cuti.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Cuti <span class="text-red-500">*</span></label>
            <select name="jenis_cuti" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Jenis Cuti --</option>
                <option value="tahunan" {{ old('jenis_cuti') === 'tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                <option value="sakit" {{ old('jenis_cuti') === 'sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                <option value="melahirkan" {{ old('jenis_cuti') === 'melahirkan' ? 'selected' : '' }}>Cuti Melahirkan</option>
                <option value="alasan_penting" {{ old('jenis_cuti') === 'alasan_penting' ? 'selected' : '' }}>Alasan Penting</option>
            </select>
            @error('jenis_cuti')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('tanggal_mulai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('tanggal_selesai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan <span class="text-red-500">*</span></label>
            <textarea name="alasan" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Jelaskan alasan pengajuan cuti...">{{ old('alasan') }}</textarea>
            @error('alasan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-700">
            ℹ️ Pengajuan cuti akan otomatis berlaku untuk seluruh jabatan aktif yang Anda miliki dan diteruskan ke atasan masing-masing unit kerja.
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Kirim Pengajuan</button>
            <a href="{{ route('cuti.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection