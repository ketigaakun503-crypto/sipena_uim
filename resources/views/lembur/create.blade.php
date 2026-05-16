@extends('layouts.app')
@section('title', 'Ajukan Lembur')
@section('header', 'Form Pengajuan Lembur')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('lembur.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lembur <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal_lembur" value="{{ old('tanggal_lembur') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('tanggal_lembur')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('jam_mulai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('jam_selesai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Lembur <span class="text-red-500">*</span></label>
            <textarea name="alasan" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Jelaskan alasan lembur...">{{ old('alasan') }}</textarea>
            @error('alasan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Kirim Pengajuan</button>
            <a href="{{ route('lembur.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection