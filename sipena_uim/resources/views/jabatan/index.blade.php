@extends('layouts.app')
@section('title', 'Jabatan')
@section('header', 'Manajemen Jabatan')

@section('content')
<div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-3 mb-6">
    <p class="text-gray-500 text-sm">Daftar seluruh jabatan di lingkungan UIM</p>
    <a href="{{ route('jabatan.create') }}"
        class="bg-[#1E3A5F] hover:bg-[#16304f] px-4 py-2 rounded-lg font-medium text-white text-sm">
        + Tambah Jabatan
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px] text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 font-semibold text-left">No</th>
                    <th class="px-4 py-3 font-semibold text-left">Nama Jabatan</th>
                    <th class="px-4 py-3 font-semibold text-left">Jenis</th>
                    <th class="px-4 py-3 font-semibold text-left">Unit Kerja</th>
                    <th class="px-4 py-3 font-semibold text-center">Level</th>
                    <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($jabatans as $i => $jabatan)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $jabatan->nama }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $jabatan->jenis === 'struktural' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $jabatan->jenis === 'akademik' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $jabatan->jenis === 'tendik' ? 'bg-orange-100 text-orange-700' : '' }}">
                            {{ ucfirst($jabatan->jenis) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $jabatan->unitKerja->nama }}</td>
                    <td class="px-4 py-3 text-gray-700 text-center">{{ $jabatan->level }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center items-center gap-1">
                            <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                                class="bg-amber-50 hover:bg-amber-100 px-2 py-1.5 rounded-lg font-medium text-amber-600 text-xs">Edit</a>
                            <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus jabatan ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded-lg font-medium text-red-600 text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-gray-400 text-center">Belum ada data jabatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection