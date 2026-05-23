@extends('layouts.app')
@section('title', 'Surat Keputusan')
@section('header', 'Manajemen Surat Keputusan')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <p class="text-gray-500 text-sm">Daftar seluruh Surat Keputusan pegawai</p>
    <a href="{{ route('surat-keputusan.create') }}"
        class="bg-[#1E3A5F] text-white px-4 py-2 rounded-lg hover:bg-[#16304f] text-sm font-medium">
        + Buat SK
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[750px]">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Pegawai</th>
                    <th class="px-4 py-3 text-left font-semibold">Nomor SK</th>
                    <th class="px-4 py-3 text-left font-semibold">Jenis SK</th>
                    <th class="px-4 py-3 text-left font-semibold">Jabatan Ditetapkan</th>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal SK</th>
                    <th class="px-4 py-3 text-center font-semibold">Status</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($skList as $i => $sk)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $sk->pegawai->nama_lengkap }}</div>
                        <div class="text-xs text-gray-400">{{ $sk->pegawai->nidn ?? $sk->pegawai->nip ?? '-' }}</div>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $sk->nomor_sk }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $sk->jenis_sk === 'pengangkatan' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $sk->jenis_sk === 'jabatan_fungsional' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $sk->jenis_sk === 'jabatan_struktural' ? 'bg-purple-100 text-purple-700' : '' }}">
                            {{ $sk->jenis_sk_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-700 text-xs">{{ $sk->jabatan_yang_ditetapkan }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $sk->tanggal_sk->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $sk->status === 'diterbitkan' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $sk->status === 'draft' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $sk->status === 'tidak_berlaku' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst(str_replace('_', ' ', $sk->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('surat-keputusan.show', $sk->id) }}"
                                class="text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-2 py-1.5 rounded-lg">Detail</a>
                            @if($sk->status === 'draft')
                            <form action="{{ route('surat-keputusan.terbitkan', $sk->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 px-2 py-1.5 rounded-lg">Terbitkan</button>
                            </form>
                            @endif
                            <a href="{{ route('surat-keputusan.pdf', $sk->id) }}"
                                class="text-xs font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 px-2 py-1.5 rounded-lg">PDF</a>
                            <form action="{{ route('surat-keputusan.destroy', $sk->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus SK ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">Belum ada data SK.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection