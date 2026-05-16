@extends('layouts.app')
@section('title', 'Unit Kerja')
@section('header', 'Manajemen Unit Kerja')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Daftar seluruh unit kerja di lingkungan UIM</p>
    <a href="{{ route('unit-kerja.create') }}"
        class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm font-medium">
        + Tambah Unit Kerja
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama Unit Kerja</th>
                <th class="px-6 py-3 text-left">Jenis</th>
                <th class="px-6 py-3 text-left">Parent</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($unitKerjas as $i => $uk)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $uk->nama }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $uk->jenis === 'fakultas' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $uk->jenis === 'prodi' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $uk->jenis === 'biro' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $uk->jenis === 'lembaga' ? 'bg-purple-100 text-purple-700' : '' }}">
                        {{ ucfirst($uk->jenis) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $uk->parent?->nama ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('unit-kerja.edit', $uk->id) }}"
                        class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('unit-kerja.destroy', $uk->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin hapus unit kerja ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data unit kerja.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection