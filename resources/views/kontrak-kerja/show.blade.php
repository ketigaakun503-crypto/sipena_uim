@extends('layouts.app')
@section('title', 'Detail Kontrak')
@section('header', 'Detail Kontrak Kerja')

@section('content')
<div class="max-w-2xl space-y-4">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex justify-between items-start mb-5">
            <div>
                <h3 class="font-semibold text-gray-800">{{ $kontrak->pegawai->nama_lengkap }}</h3>
                <p class="text-xs font-mono text-gray-500 mt-0.5">{{ $kontrak->nomor_kontrak }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('kontrak-kerja.pdf', $kontrak->id) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    Download PDF
                </a>
                <span class="px-3 py-2 rounded-full text-sm font-medium
                    {{ $kontrak->status === 'aktif' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $kontrak->status === 'berakhir' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $kontrak->status === 'diperpanjang' ? 'bg-blue-100 text-blue-700' : '' }}">
                    {{ ucfirst($kontrak->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Jenis Kontrak</p>
                <p class="font-medium">{{ ucwords(str_replace('_', ' ', $kontrak->jenis_kontrak)) }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tanggal Mulai</p>
                <p class="font-medium">{{ $kontrak->tanggal_mulai->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tanggal Selesai</p>
                <p class="font-medium">{{ $kontrak->tanggal_selesai ? $kontrak->tanggal_selesai->format('d F Y') : 'Tidak terbatas' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Sisa Hari</p>
                <p class="font-medium {{ $kontrak->is_akan_berakhir ? 'text-red-600' : 'text-gray-800' }}">
                    {{ $kontrak->tanggal_selesai ? $kontrak->sisa_hari . ' hari' : '—' }}
                    @if($kontrak->is_akan_berakhir) ⚠️ Segera berakhir! @endif
                </p>
            </div>
            @if($kontrak->keterangan)
            <div class="col-span-2">
                <p class="text-gray-400">Keterangan</p>
                <p class="font-medium">{{ $kontrak->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('kontrak-kerja.edit', $kontrak->id) }}"
            class="bg-amber-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-amber-600">Edit</a>
        <a href="{{ route('kontrak-kerja.index') }}" class="text-gray-500 hover:underline text-sm self-center">← Kembali</a>
    </div>
</div>
@endsection