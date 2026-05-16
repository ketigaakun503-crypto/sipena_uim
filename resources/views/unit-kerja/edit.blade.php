@extends('layouts.app')
@section('title', 'Edit Unit Kerja')
@section('header', 'Edit Unit Kerja')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('unit-kerja.update', $unitKerja->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Unit Kerja</label>
            <input type="text" name="nama" value="{{ old('nama', $unitKerja->nama) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
            <select name="jenis" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @foreach(['fakultas','prodi','biro','lembaga'] as $jenis)
                    <option value="{{ $jenis }}" {{ old('jenis', $unitKerja->jenis) === $jenis ? 'selected' : '' }}>
                        {{ ucfirst($jenis) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Parent (opsional)</label>
            <select name="parent_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Tidak ada parent --</option>
                @foreach($parents as $parent)
                    @if($parent->id !== $unitKerja->id)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $unitKerja->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->nama }}
                    </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Update</button>
            <a href="{{ route('unit-kerja.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection