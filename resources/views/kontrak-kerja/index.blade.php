@extends('layouts.app')
@section('title', 'Kontrak Kerja')
@section('header', 'Manajemen Kontrak Kerja')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <p class="text-gray-500 text-sm">Daftar seluruh kontrak kerja pegawai</p>
    <a href="{{ route('kontrak-kerja.create') }}"
        class="bg-[#1E3A5F] text-white px-4 py-2 rounded-lg hover:bg-[#16304f] text-sm font-medium">
        + Tambah Kontrak
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[700px]">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Pegawai</th>
                    <th class="px-4 py-3 text-left font-semibold">Nomor Kontrak</th>
                    <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                    <th class="px-4 py-3 text-left font-semibold">Periode</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Hari</th>
                    <th class="px-4 py-3 text-center font-semibold">Status</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($kontrakList as $i => $k)
                <tr class="hover:bg-gray-50/50 {{ $k->is_akan_berakhir ? 'bg-yellow-50/50' : '' }}">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $k->pegawai->nama_lengkap }}</div>
                        <div class="text-xs text-gray-400">{{ $k->pegawai->nip ?? $k->pegawai->nidn ?? '-' }}</div>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $k->nomor_kontrak }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $k->jenis_kontrak === 'tetap' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $k->jenis_kontrak === 'tidak_tetap' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $k->jenis_kontrak === 'paruh_waktu' ? 'bg-purple-100 text-purple-700' : '' }}">
                            {{ ucwords(str_replace('_', ' ', $k->jenis_kontrak)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">
                        {{ $k->tanggal_mulai->format('d/m/Y') }} –
                        {{ $k->tanggal_selesai ? $k->tanggal_selesai->format('d/m/Y') : 'Tidak terbatas' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($k->tanggal_selesai)
                            <span class="font-medium text-sm {{ $k->is_akan_berakhir ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $k->sisa_hari }} hari
                                @if($k->is_akan_berakhir)
                                    ⚠️
                                @endif
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $k->status === 'aktif' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $k->status === 'berakhir' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $k->status === 'diperpanjang' ? 'bg-blue-100 text-blue-700' : '' }}">
                            {{ ucfirst($k->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('kontrak-kerja.show', $k->id) }}"
                                class="text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-2 py-1.5 rounded-lg">Detail</a>
                            <a href="{{ route('kontrak-kerja.edit', $k->id) }}"
                                class="text-xs font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 px-2 py-1.5 rounded-lg">Edit</a>
                            <a href="{{ route('kontrak-kerja.pdf', $k->id) }}"
                                class="text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 px-2 py-1.5 rounded-lg">PDF</a>
                            <form action="{{ route('kontrak-kerja.destroy', $k->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus kontrak ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">Belum ada data kontrak kerja.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection