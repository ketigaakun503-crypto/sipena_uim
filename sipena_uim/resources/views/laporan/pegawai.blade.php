@extends('layouts.app')
@section('title', 'Laporan Pegawai')
@section('header', 'Laporan Data Pegawai')

@section('content')
<div class="bg-white mb-5 p-4 border border-gray-200 rounded-xl">
    <form action="{{ route('laporan.pegawai') }}" method="GET">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block mb-1 font-medium text-gray-600 text-xs">Jenis Pegawai</label>
                <select name="jenis_pegawai" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                    <option value="">Semua</option>
                    <option value="dosen" {{ request('jenis_pegawai') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="tendik" {{ request('jenis_pegawai') === 'tendik' ? 'selected' : '' }}>Tendik</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-600 text-xs">Status</label>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                    <option value="pensiun" {{ request('status') === 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                </select>
            </div>
            <button type="submit" class="bg-[#1E3A5F] px-4 py-2 rounded-lg text-white text-sm">Filter</button>
            <a href="{{ route('laporan.pegawai.pdf', request()->all()) }}"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white text-sm">PDF</a>
            <a href="{{ route('laporan.pegawai.excel', request()->all()) }}"
                class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white text-sm">Excel</a>
        </div>
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="px-4 py-3 border-gray-100 border-b">
        <h3 class="font-semibold text-gray-700 text-sm">Total: {{ $pegawais->count() }} pegawai</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px] text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 font-semibold text-left">No</th>
                    <th class="px-4 py-3 font-semibold text-left">Nama Lengkap</th>
                    <th class="px-4 py-3 font-semibold text-left">NIP/NIDN</th>
                    <th class="px-4 py-3 font-semibold text-left">Jenis</th>
                    <th class="px-4 py-3 font-semibold text-left">Jabatan Aktif</th>
                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pegawais as $i => $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->nama_lengkap }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->nip ?? $p->nidn ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs
                            {{ $p->jenis_pegawai === 'dosen' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ ucfirst($p->jenis_pegawai) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">
                        {{ $p->jabatanAktif->pluck('nama')->implode(', ') ?: '-' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs
                            {{ $p->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
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