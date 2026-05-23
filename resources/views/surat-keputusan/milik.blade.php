@extends('layouts.app')
@section('title', 'SK Saya')
@section('header', 'Surat Keputusan Saya')

@section('content')
<div class="space-y-4">
    @forelse($skList as $sk)
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex justify-between items-start">
            <div>
                <span class="px-2 py-1 rounded-full text-xs font-medium
                    {{ $sk->jenis_sk === 'pengangkatan' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $sk->jenis_sk === 'jabatan_fungsional' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $sk->jenis_sk === 'jabatan_struktural' ? 'bg-purple-100 text-purple-700' : '' }}">
                    {{ $sk->jenis_sk_label }}
                </span>
                <h3 class="font-semibold text-gray-800 mt-2">{{ $sk->jabatan_yang_ditetapkan }}</h3>
                <p class="text-xs font-mono text-gray-500 mt-0.5">{{ $sk->nomor_sk }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $sk->status === 'diterbitkan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ ucfirst(str_replace('_', ' ', $sk->status)) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4 text-sm">
            <div>
                <p class="text-gray-400">Tanggal SK</p>
                <p class="font-medium">{{ $sk->tanggal_sk->format('d F Y') }}</p>
            </div>
            @if($sk->tmt)
            <div>
                <p class="text-gray-400">TMT</p>
                <p class="font-medium">{{ $sk->tmt->format('d F Y') }}</p>
            </div>
            @endif
        </div>

        @if($sk->status === 'diterbitkan')
        <div class="mt-4">
            <a href="{{ route('surat-keputusan.pdf', $sk->id) }}"
                class="inline-flex items-center gap-2 text-sm text-purple-600 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg">
                Download PDF SK
            </a>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
        Belum ada Surat Keputusan.
    </div>
    @endforelse
</div>
@endsection