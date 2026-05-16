@extends('layouts.app')
@section('title', 'Laporan Cuti')
@section('header', 'Laporan Rekap Cuti')

@section('content')
<div class="bg-white mb-5 p-4 border border-gray-200 rounded-xl">
    <form action="{{ route('laporan.cuti') }}" method="GET">
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
                <label class="block mb-1 font-medium text-gray-600 text-xs">Tahun</label>
                <select name="tahun" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none text-sm">
                    @foreach(range(now()->year, now()->year - 3) as $y)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-600 text-xs">Status</label>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none text-sm">
                    <option value="">Semua</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="bg-[#1E3A5F] px-4 py-2 rounded-lg text-white text-sm">Filter</button>
            <a href="{{ route('laporan.cuti.pdf', request()->all()) }}"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white text-sm">PDF</a>
            <a href="{{ route('laporan.cuti.excel', request()->all()) }}"
                class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white text-sm">Excel</a>
        </div>
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="px-4 py-3 border-gray-100 border-b">
        <h3 class="font-semibold text-gray-700 text-sm">Total: {{ $pengajuan->count() }} pengajuan</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px] text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 font-semibold text-left">No</th>
                    <th class="px-4 py-3 font-semibold text-left">Nama Pegawai</th>
                    <th class="px-4 py-3 font-semibold text-left">Jenis Cuti</th>
                    <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-center">Hari</th>
                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pengajuan as $i => $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->pegawai->nama_lengkap }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ ucwords(str_replace('_', ' ', $p->jenis_cuti)) }}</td>
                    <td class="px-4 py-3 text-gray-600 text-xs">
                        {{ $p->tanggal_mulai->format('d/m/Y') }} – {{ $p->tanggal_selesai->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3 font-medium text-center">{{ $p->jumlah_hari }}</td>
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