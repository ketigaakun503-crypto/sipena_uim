@extends('layouts.app')
@section('title', 'Detail Lembur')
@section('header', 'Detail Pengajuan Lembur')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm p-6 space-y-4">
    <div class="flex justify-between items-start">
        <h3 class="font-semibold text-gray-700">Informasi Lembur</h3>
        <span class="px-3 py-1 rounded-full text-sm font-medium
            {{ $pengajuan->status === 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
            {{ $pengajuan->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
            {{ $pengajuan->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}">
            {{ ucfirst($pengajuan->status) }}
        </span>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-400">Tanggal</p>
            <p class="font-medium">{{ \Carbon\Carbon::parse($pengajuan->tanggal_lembur)->format('d F Y') }}</p>
        </div>
        <div>
            <p class="text-gray-400">Total Jam</p>
            <p class="font-medium text-blue-900">{{ $pengajuan->jumlah_jam }} jam</p>
        </div>
        <div>
            <p class="text-gray-400">Jam Mulai</p>
            <p class="font-medium">{{ $pengajuan->jam_mulai }}</p>
        </div>
        <div>
            <p class="text-gray-400">Jam Selesai</p>
            <p class="font-medium">{{ $pengajuan->jam_selesai }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-400">Alasan</p>
            <p class="font-medium">{{ $pengajuan->alasan }}</p>
        </div>
    </div>

    <hr>
    <h4 class="font-semibold text-gray-700">Status Persetujuan</h4>
    @forelse($pengajuan->approvals as $approval)
    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50">
        @if($approval->status === 'disetujui') ✅
        @elseif($approval->status === 'ditolak') ❌
        @else ⏳
        @endif
        <div>
            <p class="text-sm font-medium">{{ $approval->approver->name }}</p>
            @if($approval->catatan)
                <p class="text-xs text-gray-500">"{{ $approval->catatan }}"</p>
            @endif
        </div>
    </div>
    @empty
    <p class="text-gray-400 text-sm">Belum ada proses persetujuan.</p>
    @endforelse

    <a href="{{ route('lembur.index') }}" class="text-gray-500 hover:underline text-sm">← Kembali</a>
</div>
@endsection