@extends('layouts.app')
@section('title', 'Laporan Cuti')
@section('header', 'Laporan Rekap Cuti')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('laporan.cuti') }}" method="GET" class="flex gap-4 items-end">
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
            <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
            <select name="tahun" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                @foreach(range(now()->year, now()->year - 3) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                <option value="">Semua</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
        <a href="{{ route('laporan.cuti.pdf', request()->all()) }}"
            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">📄 Export PDF</a>
        <a href="{{ route('laporan.cuti.excel', request()->all()) }}"
            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">📊 Export Excel</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-700">Total: {{ $pengajuan->count() }} pengajuan</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama Pegawai</th>
                <th class="px-6 py-3 text-left">Jenis Cuti</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-center">Hari</th>
                <th class="px-6 py-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pengajuan as $i => $p)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $i + 1 }}</td>
                <td class="px-6 py-3 font-medium">{{ $p->pegawai->nama_lengkap }}</td>
                <td class="px-6 py-3">{{ ucwords(str_replace('_', ' ', $p->jenis_cuti)) }}</td>
                <td class="px-6 py-3 text-gray-600">
                    {{ $p->tanggal_mulai->format('d/m/Y') }} – {{ $p->tanggal_selesai->format('d/m/Y') }}
                </td>
                <td class="px-6 py-3 text-center">{{ $p->jumlah_hari }}</td>
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