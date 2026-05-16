@extends('layouts.app')
@section('title', 'Tambah Jabatan')
@section('header', 'Tambah Jabatan')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('jabatan.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jabatan</label>
            <input type="text" name="nama" value="{{ old('nama') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Contoh: Kaprodi Informatika">
            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
            <select name="jenis" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Jenis --</option>
                @foreach(['struktural','akademik','tendik'] as $jenis)
                    <option value="{{ $jenis }}" {{ old('jenis') === $jenis ? 'selected' : '' }}>
                        {{ ucfirst($jenis) }}
                    </option>
                @endforeach
            </select>
            @error('jenis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
            <select name="unit_kerja_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Unit Kerja --</option>
                @foreach($unitKerjas as $uk)
                    <option value="{{ $uk->id }}" {{ old('unit_kerja_id') == $uk->id ? 'selected' : '' }}>
                        {{ $uk->nama }}
                    </option>
                @endforeach
            </select>
            @error('unit_kerja_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Level Hierarki</label>
            <input type="number" name="level" value="{{ old('level', 0) }}" min="0"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="0 = tertinggi (Rektor)">
            <p class="text-xs text-gray-400 mt-1">0=Rektor, 1=Wakil Rektor/Dekan, 2=Kaprodi/Ka.Biro, dst</p>
            @error('level')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Simpan</button>
            <a href="{{ route('jabatan.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection