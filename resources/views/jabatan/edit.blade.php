@extends('layouts.app')
@section('title', 'Edit Jabatan')
@section('header', 'Edit Jabatan')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jabatan</label>
            <input type="text" name="nama" value="{{ old('nama', $jabatan->nama) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
            <select name="jenis" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @foreach(['struktural','akademik','tendik'] as $jenis)
                    <option value="{{ $jenis }}" {{ old('jenis', $jabatan->jenis) === $jenis ? 'selected' : '' }}>
                        {{ ucfirst($jenis) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
            <select name="unit_kerja_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @foreach($unitKerjas as $uk)
                    <option value="{{ $uk->id }}" {{ old('unit_kerja_id', $jabatan->unit_kerja_id) == $uk->id ? 'selected' : '' }}>
                        {{ $uk->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Level Hierarki</label>
            <input type="number" name="level" value="{{ old('level', $jabatan->level) }}" min="0"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <p class="text-xs text-gray-400 mt-1">0=Rektor, 1=Wakil Rektor/Dekan, 2=Kaprodi/Ka.Biro, dst</p>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Update</button>
            <a href="{{ route('jabatan.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection