@extends('layouts.app')
@section('title', 'Ajukan Surat Jafa')
@section('header', 'Form Pengajuan Surat Jafa')

@section('content')
<div class="max-w-2xl bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('jafa.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Fungsional yang Diajukan <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan_fungsional_diajukan" value="{{ old('jabatan_fungsional_diajukan') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: Lektor Kepala">
                @error('jabatan_fungsional_diajukan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Fungsional Sekarang <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan_fungsional_sekarang" value="{{ old('jabatan_fungsional_sekarang') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: Lektor">
                @error('jabatan_fungsional_sekarang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pangkat/Golongan <span class="text-red-500">*</span></label>
                <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: Penata / III-C">
                @error('pangkat_golongan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">TMT Pangkat <span class="text-red-500">*</span></label>
                <input type="date" name="tmt_pangkat" value="{{ old('tmt_pangkat') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('tmt_pangkat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Karya Ilmiah</label>
                <textarea name="daftar_karya" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Tuliskan daftar karya ilmiah yang diajukan...">{{ old('daftar_karya') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Ajukan Surat</button>
            <a href="{{ route('jafa.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection