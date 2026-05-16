@extends('layouts.app')
@section('title', 'Laporan Lembur')
@section('header', 'Laporan Rekap Lembur')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('laporan.lembur') }}" method="GET" class="flex gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
            <select name="bulan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                <option value="">Semua Bulan</option>
                @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                <option value="">Semua</option>
                <option value="menunggu">Menunggu</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
        <a href="{{ route('laporan.lembur.pdf', request()->all()) }}"
            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">📄 Export PDF</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama Pegawai</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Jam</th>
                <th class="px-6 py-3 text-center">Total Jam</th>
                <th class="px-6 py-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pengajuan as $i => $p)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $i + 1 }}</td>
                <td class="px-6 py-3 font-medium">{{ $p->pegawai->nama_lengkap }}</td>
                <td class="px-6 py-3">{{ \Carbon\Carbon::parse($p->tanggal_lembur)->format('d/m/Y') }}</td>
                <td class="px-6 py-3 text-gray-600">{{ $p->jam_mulai }} – {{ $p->jam_selesai }}</td>
                <td class="px-6 py-3 text-center font-medium">{{ $p->jumlah_jam }} jam</td>
                <td class="px-6 py-3 text-center">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $p->status === 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $p->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $p->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection