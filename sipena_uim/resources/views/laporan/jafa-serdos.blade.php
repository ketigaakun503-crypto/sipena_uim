@extends('layouts.app')
@section('title', 'Laporan Jafa & Serdos')
@section('header', 'Laporan Progres Jafa & Serdos')

@section('content')
<div class="grid grid-cols-2 gap-6">
    {{-- Jafa --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="font-semibold text-gray-700">📋 Progres Surat Jafa ({{ $jafas->count() }})</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Dosen</th>
                    <th class="px-4 py-3 text-left">Diajukan</th>
                    <th class="px-4 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jafas as $j)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-xs">{{ $j->pegawai->nama_lengkap }}</p>
                        <p class="text-gray-400 text-xs">{{ $j->jabatan_fungsional_diajukan }}</p>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $j->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $j->status === 'diverifikasi' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $j->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $j->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ ucfirst($j->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400 text-xs">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Serdos --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="font-semibold text-gray-700">🎓 Progres Surat Serdos ({{ $serdos->count() }})</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Dosen</th>
                    <th class="px-4 py-3 text-left">Prodi</th>
                    <th class="px-4 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($serdos as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-xs">{{ $s->pegawai->nama_lengkap }}</p>
                        <p class="text-gray-400 text-xs">{{ $s->bidang_ilmu }}</p>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $s->program_studi }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $s->status === 'diverifikasi' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $s->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $s->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400 text-xs">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection