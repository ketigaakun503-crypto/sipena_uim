@extends('layouts.app')
@section('title', 'Laporan Lembur')
@section('header', 'Laporan Rekap Lembur')

@section('content')
<div class="bg-white mb-5 p-4 border border-gray-200 rounded-xl">
    <form action="{{ route('laporan.lembur') }}" method="GET">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block mb-1 font-medium text-gray-600 text-xs">Bulan</label>
                <select name="bulan" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none text-sm">
                    <option value="">Semua</option>
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-600 text-xs">Status</label>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none text-sm">
                    <option value="">Semua</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <button type="submit" class="bg-[#1E3A5F] px-4 py-2 rounded-lg text-white text-sm">Filter</button>
            <a href="{{ route('laporan.lembur.pdf', request()->all()) }}"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white text-sm">PDF</a>
        </div>
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[550px] text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 font-semibold text-left">No</th>
                    <th class="px-4 py-3 font-semibold text-left">Nama Pegawai</th>
                    <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-left">Jam</th>
                    <th class="px-4 py-3 font-semibold text-center">Total Jam</th>
                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pengajuan as $i => $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->pegawai->nama_lengkap }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($p->tanggal_lembur)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->jam_mulai }} – {{ $p->jam_selesai }}</td>
                    <td class="px-4 py-3 font-medium text-center">{{ $p->jumlah_jam }} jam</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $p->status === 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $p->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $p->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-gray-400 text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection