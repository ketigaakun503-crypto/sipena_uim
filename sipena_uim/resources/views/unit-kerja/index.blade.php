@extends('layouts.app')
@section('title', 'Unit Kerja')
@section('header', 'Manajemen Unit Kerja')

@section('content')
<div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-3 mb-6">
    <p class="text-gray-500 text-sm">Daftar seluruh unit kerja di lingkungan UIM</p>
    <a href="{{ route('unit-kerja.create') }}"
        class="bg-[#1E3A5F] hover:bg-[#16304f] px-4 py-2 rounded-lg font-medium text-white text-sm">
        + Tambah Unit Kerja
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[500px] text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 font-semibold text-left">No</th>
                    <th class="px-4 py-3 font-semibold text-left">Nama Unit Kerja</th>
                    <th class="px-4 py-3 font-semibold text-left">Jenis</th>
                    <th class="px-4 py-3 font-semibold text-left">Parent</th>
                    <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($unitKerjas as $i => $uk)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $uk->nama }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $uk->jenis === 'fakultas' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $uk->jenis === 'prodi' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $uk->jenis === 'biro' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $uk->jenis === 'lembaga' ? 'bg-purple-100 text-purple-700' : '' }}">
                            {{ ucfirst($uk->jenis) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $uk->parent?->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center items-center gap-1">
                            <a href="{{ route('unit-kerja.edit', $uk->id) }}"
                                class="bg-amber-50 hover:bg-amber-100 px-2 py-1.5 rounded-lg font-medium text-amber-600 text-xs">Edit</a>
                            <form action="{{ route('unit-kerja.destroy', $uk->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus unit kerja ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded-lg font-medium text-red-600 text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-gray-400 text-center">Belum ada data unit kerja.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection