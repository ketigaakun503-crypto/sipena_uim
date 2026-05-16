@extends('layouts.app')
@section('title', 'Surat Serdos')
@section('header', 'E-Letter Sertifikasi Dosen (Serdos)')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Daftar pengajuan surat pengantar Serdos Anda</p>
    <a href="{{ route('serdos.create') }}"
        class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm">
        + Ajukan Surat Serdos
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nomor Surat</th>
                <th class="px-6 py-3 text-left">Program Studi</th>
                <th class="px-6 py-3 text-left">Bidang Ilmu</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($surat as $i => $s)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-mono text-sm">{{ $s->nomor_surat }}</td>
                <td class="px-6 py-4">{{ $s->program_studi }}</td>
                <td class="px-6 py-4">{{ $s->bidang_ilmu }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $s->status === 'diverifikasi' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $s->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $s->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($s->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('serdos.show', $s->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    <a href="{{ route('serdos.pdf', $s->id) }}" class="text-green-600 hover:underline">PDF</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pengajuan surat Serdos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection