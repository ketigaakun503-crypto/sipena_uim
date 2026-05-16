@extends('layouts.app')
@section('title', 'Pengajuan Cuti')
@section('header', 'Pengajuan Cuti')

@section('content')
<div class="gap-4 grid grid-cols-3 mb-6">
    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <p class="font-medium text-gray-500 text-xs uppercase tracking-wide">Jatah Cuti</p>
        <h3 class="mt-1 font-bold text-[#1E3A5F] text-3xl">12</h3>
        <p class="mt-1 text-gray-400 text-xs">hari per tahun</p>
    </div>
    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <p class="font-medium text-gray-500 text-xs uppercase tracking-wide">Sisa Cuti</p>
        <h3 class="text-3xl font-bold mt-1 {{ $pegawai->sisa_cuti < 0 ? 'text-red-500' : 'text-green-600' }}">
            {{ $pegawai->sisa_cuti }}
        </h3>
        <p class="mt-1 text-gray-400 text-xs">hari tersisa</p>
    </div>
    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <p class="font-medium text-gray-500 text-xs uppercase tracking-wide">Total Pengajuan</p>
        <h3 class="mt-1 font-bold text-orange-500 text-3xl">{{ $pengajuan->count() }}</h3>
        <p class="mt-1 text-gray-400 text-xs">semua pengajuan</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="flex justify-between items-center px-6 py-4 border-gray-100 border-b">
        <h3 class="font-semibold text-gray-700 text-sm">Riwayat Pengajuan Cuti</h3>
        <a href="{{ route('cuti.create') }}"
            class="inline-flex items-center gap-2 bg-[#1E3A5F] hover:bg-[#16304f] px-4 py-2 rounded-lg font-medium text-white text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajukan Cuti
        </a>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 font-semibold text-left">No</th>
                <th class="px-6 py-3 font-semibold text-left">Jenis Cuti</th>
                <th class="px-6 py-3 font-semibold text-left">Tanggal</th>
                <th class="px-6 py-3 font-semibold text-center">Hari</th>
                <th class="px-6 py-3 font-semibold text-center">Status</th>
                <th class="px-6 py-3 font-semibold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($pengajuan as $i => $p)
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4 text-gray-500">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ ucwords(str_replace('_', ' ', $p->jenis_cuti)) }}
                </td>
                <td class="px-6 py-4 text-gray-600">
                    {{ $p->tanggal_mulai->format('d/m/Y') }} &ndash; {{ $p->tanggal_selesai->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-700 text-center">{{ $p->jumlah_hari }} hari</td>
                <td class="px-6 py-4 text-center">
                    @if($p->status === 'disetujui')
                        <span class="inline-flex items-center bg-green-100 px-2.5 py-1 rounded-full font-medium text-green-700 text-xs">Disetujui</span>
                    @elseif($p->status === 'ditolak')
                        <span class="inline-flex items-center bg-red-100 px-2.5 py-1 rounded-full font-medium text-red-700 text-xs">Ditolak</span>
                    @else
                        <span class="inline-flex items-center bg-yellow-100 px-2.5 py-1 rounded-full font-medium text-yellow-700 text-xs">Menunggu</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center items-center gap-2">
                        <a href="{{ route('cuti.show', $p->id) }}"
                            class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg font-medium text-blue-600 hover:text-blue-800 text-xs transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>
                        @if($p->status === 'menunggu')
                        <form action="{{ route('cuti.batal', $p->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg font-medium text-red-600 hover:text-red-800 text-xs transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-gray-400 text-center">
                    <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Belum ada pengajuan cuti.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection