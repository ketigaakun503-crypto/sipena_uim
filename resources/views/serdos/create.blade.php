@extends('layouts.app')
@section('title', 'Ajukan Surat Serdos')
@section('header', 'Form Pengajuan Surat Serdos')

@section('content')
<div class="max-w-2xl bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('serdos.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="program_studi" value="{{ old('program_studi') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: Informatika">
                @error('program_studi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bidang Ilmu <span class="text-red-500">*</span></label>
                <input type="text" name="bidang_ilmu" value="{{ old('bidang_ilmu') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: Ilmu Komputer">
                @error('bidang_ilmu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah SKS Mengajar <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah_sks" value="{{ old('jumlah_sks') }}" min="1"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('jumlah_sks')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai Mengajar <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_mulai_mengajar" value="{{ old('tahun_mulai_mengajar') }}" min="1990" max="{{ date('Y') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('tahun_mulai_mengajar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah yang Diampu</label>
                <textarea name="mata_kuliah" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Daftar mata kuliah yang pernah diampu...">{{ old('mata_kuliah') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Ajukan Surat</button>
            <a href="{{ route('serdos.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection