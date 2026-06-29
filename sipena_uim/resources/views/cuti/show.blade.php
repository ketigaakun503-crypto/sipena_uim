@extends('layouts.app')
@section('title', 'Detail Cuti')
@section('header', 'Detail Pengajuan Cuti')

@section('content')
<div class="max-w-2xl space-y-4">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-4">
            <h3 class="font-semibold text-gray-700">Informasi Pengajuan</h3>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $pengajuan->status === 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                {{ $pengajuan->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                {{ $pengajuan->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                {{ ucfirst($pengajuan->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Jenis Cuti</p>
                <p class="font-medium">{{ ucwords(str_replace('_', ' ', $pengajuan->jenis_cuti)) }}</p>
            </div>
            <div>
                <p class="text-gray-400">Jumlah Hari</p>
                <p class="font-medium">{{ $pengajuan->jumlah_hari }} hari kerja</p>
            </div>
            <div>
                <p class="text-gray-400">Tanggal Mulai</p>
                <p class="font-medium">{{ $pengajuan->tanggal_mulai->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tanggal Selesai</p>
                <p class="font-medium">{{ $pengajuan->tanggal_selesai->format('d F Y') }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-400">Alasan</p>
                <p class="font-medium">{{ $pengajuan->alasan }}</p>
            </div>
        </div>
    </div>

    {{-- Timeline Approval --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Timeline Persetujuan</h3>
        <div class="space-y-3">
            @forelse($pengajuan->approvals as $approval)
            <div class="flex items-start gap-4 p-3 rounded-lg
                {{ $approval->status === 'disetujui' ? 'bg-green-50' : '' }}
                {{ $approval->status === 'ditolak' ? 'bg-red-50' : '' }}
                {{ $approval->status === 'menunggu' ? 'bg-yellow-50' : '' }}">
                <div class="mt-1">
                    @if($approval->status === 'disetujui') ✅
                    @elseif($approval->status === 'ditolak') ❌
                    @else ⏳
                    @endif
                </div>
                <div>
                    <p class="font-medium text-sm text-gray-800">{{ $approval->approver->name }}</p>
                    <p class="text-xs text-gray-500">{{ $approval->jabatan->nama ?? '-' }}</p>
                    @if($approval->catatan)
                        <p class="text-xs text-gray-600 mt-1">"{{ $approval->catatan }}"</p>
                    @endif
                    @if($approval->diproses_pada)
                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($approval->diproses_pada)->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm">Belum ada proses persetujuan.</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('cuti.index') }}" class="text-gray-500 hover:underline text-sm">← Kembali</a>
</div>
@endsection