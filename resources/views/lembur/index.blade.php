@extends('layouts.app')
@section('title', 'Pengajuan Lembur')
@section('header', 'Pengajuan Lembur')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Riwayat pengajuan lembur Anda</p>
    <a href="{{ route('lembur.create') }}"
        class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm">
        + Ajukan Lembur
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Jam</th>
                <th class="px-6 py-3 text-center">Total Jam</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pengajuan as $i => $p)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $i + 1 }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($p->tanggal_lembur)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $p->jam_mulai }} – {{ $p->jam_selesai }}</td>
                <td class="px-6 py-4 text-center font-medium">{{ $p->jumlah_jam }} jam</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $p->status === 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $p->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $p->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('lembur.show', $p->id) }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pengajuan lembur.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection