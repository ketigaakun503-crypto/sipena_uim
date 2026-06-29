@extends('layouts.app')
@section('title', 'Kontrak Kerja Saya')
@section('header', 'Kontrak Kerja Saya')

@section('content')
<div class="space-y-4">
    @forelse($kontrakList as $k)
    <div class="bg-white rounded-xl border border-gray-200 p-6 {{ $k->is_akan_berakhir ? 'border-yellow-300' : '' }}">
        @if($k->is_akan_berakhir)
        <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-2 rounded-lg mb-4 text-sm">
            ⚠️ Kontrak Anda akan berakhir dalam <strong>{{ $k->sisa_hari }} hari</strong>. Segera hubungi Admin SDM.
        </div>
        @endif

        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-semibold text-gray-800">{{ $k->nomor_kontrak }}</h3>
                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-medium
                    {{ $k->jenis_kontrak === 'tetap' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ ucwords(str_replace('_', ' ', $k->jenis_kontrak)) }}
                </span>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $k->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ ucfirst($k->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4 text-sm">
            <div>
                <p class="text-gray-400">Tanggal Mulai</p>
                <p class="font-medium">{{ $k->tanggal_mulai->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tanggal Selesai</p>
                <p class="font-medium">{{ $k->tanggal_selesai ? $k->tanggal_selesai->format('d F Y') : 'Tidak terbatas' }}</p>
            </div>
            @if($k->tanggal_selesai)
            <div>
                <p class="text-gray-400">Sisa Hari</p>
                <p class="font-medium {{ $k->is_akan_berakhir ? 'text-red-600' : 'text-gray-800' }}">
                    {{ $k->sisa_hari }} hari
                </p>
            </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('kontrak-kerja.pdf', $k->id) }}"
                class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg">
                Download PDF Kontrak
            </a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
        Belum ada data kontrak kerja.
    </div>
    @endforelse
</div>
@endsection