@extends('layouts.app')
@section('title', 'Jabatan')
@section('header', 'Manajemen Jabatan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Daftar seluruh jabatan di lingkungan UIM</p>
    <a href="{{ route('jabatan.create') }}"
        class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm font-medium">
        + Tambah Jabatan
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama Jabatan</th>
                <th class="px-6 py-3 text-left">Jenis</th>
                <th class="px-6 py-3 text-left">Unit Kerja</th>
                <th class="px-6 py-3 text-center">Level</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($jabatans as $i => $jabatan)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $jabatan->nama }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $jabatan->jenis === 'struktural' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $jabatan->jenis === 'akademik' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $jabatan->jenis === 'tendik' ? 'bg-orange-100 text-orange-700' : '' }}">
                        {{ ucfirst($jabatan->jenis) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $jabatan->unitKerja->nama }}</td>
                <td class="px-6 py-4 text-center">{{ $jabatan->level }}</td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                        class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin hapus jabatan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data jabatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection