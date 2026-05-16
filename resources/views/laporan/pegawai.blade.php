@extends('layouts.app')
@section('title', 'Laporan Pegawai')
@section('header', 'Laporan Data Pegawai')

@section('content')
{{-- Filter --}}
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('laporan.pegawai') }}" method="GET" class="flex gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Pegawai</label>
            <select name="jenis_pegawai" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                <option value="">Semua</option>
                <option value="dosen" {{ request('jenis_pegawai') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="tendik" {{ request('jenis_pegawai') === 'tendik' ? 'selected' : '' }}>Tendik</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                <option value="">Semua</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                <option value="pensiun" {{ request('status') === 'pensiun' ? 'selected' : '' }}>Pensiun</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
        <a href="{{ route('laporan.pegawai.pdf', request()->all()) }}"
            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">📄 Export PDF</a>
        <a href="{{ route('laporan.pegawai.excel', request()->all()) }}"
            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">📊 Export Excel</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-semibold text-gray-700">Total: {{ $pegawais->count() }} pegawai</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama Lengkap</th>
                <th class="px-6 py-3 text-left">NIP/NIDN</th>
                <th class="px-6 py-3 text-left">Jenis</th>
                <th class="px-6 py-3 text-left">Jabatan Aktif</th>
                <th class="px-6 py-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pegawais as $i => $p)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $i + 1 }}</td>
                <td class="px-6 py-3 font-medium">{{ $p->nama_lengkap }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $p->nip ?? $p->nidn ?? '-' }}</td>
                <td class="px-6 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs
                        {{ $p->jenis_pegawai === 'dosen' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                        {{ ucfirst($p->jenis_pegawai) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-gray-600 text-xs">
                    {{ $p->jabatanAktif->pluck('nama')->implode(', ') ?: '-' }}
                </td>
                <td class="px-6 py-3 text-center">
                    <span class="px-2 py-0.5 rounded-full text-xs
                        {{ $p->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
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