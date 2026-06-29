@extends('layouts.app')
@section('title', 'Pengajuan Lembur')
@section('header', 'Pengajuan Lembur')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-3 px-4 py-4 border-gray-100 border-b">
        <h3 class="font-semibold text-gray-700 text-sm">Riwayat Pengajuan Lembur</h3>
        <a href="{{ route('lembur.create') }}"
            class="inline-flex items-center gap-2 bg-[#1E3A5F] hover:bg-[#16304f] px-4 py-2 rounded-lg font-medium text-white text-sm">
            + Ajukan Lembur
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[550px] text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 font-semibold text-left">No</th>
                    <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-left">Jam</th>
                    <th class="px-4 py-3 font-semibold text-center">Total Jam</th>
                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                    <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pengajuan as $i => $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_lembur)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->jam_mulai }} – {{ $p->jam_selesai }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800 text-center">{{ $p->jumlah_jam }} jam</td>
                    <td class="px-4 py-3 text-center">
                        @if($p->status === 'disetujui')
                            <span class="bg-green-100 px-2 py-1 rounded-full font-medium text-green-700 text-xs">Disetujui</span>
                        @elseif($p->status === 'ditolak')
                            <span class="bg-red-100 px-2 py-1 rounded-full font-medium text-red-700 text-xs">Ditolak</span>
                        @else
                            <span class="bg-yellow-100 px-2 py-1 rounded-full font-medium text-yellow-700 text-xs">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('lembur.show', $p->id) }}"
                            class="bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg font-medium text-blue-600 text-xs">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-gray-400 text-center">Belum ada pengajuan lembur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection