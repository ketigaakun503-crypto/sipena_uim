@extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Dashboard Saya')

@section('content')
{{-- Welcome Banner --}}
<div class="bg-[#1E3A5F] mb-6 p-6 rounded-2xl text-white">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-blue-200 text-sm">Selamat datang kembali,</p>
            <h2 class="mt-0.5 font-bold text-2xl">{{ $pegawai->nama_lengkap }}</h2>
            <div class="flex items-center gap-2 mt-2">
                <span class="bg-white/15 px-3 py-1 border border-white/20 rounded-full text-blue-100 text-xs">
                    {{ ucfirst($pegawai->jenis_pegawai) }}
                </span>
                <span class="bg-green-500/20 px-3 py-1 border border-green-400/30 rounded-full text-green-300 text-xs">
                    {{ ucfirst($pegawai->status) }}
                </span>
            </div>
        </div>
        <div class="flex justify-center items-center bg-white/10 rounded-2xl w-16 h-16">
            <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="gap-4 grid grid-cols-3 mb-6">
    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Sisa Cuti</p>
            <div class="w-8 h-8 {{ $sisaCuti < 0 ? 'bg-red-50' : 'bg-blue-50' }} rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 {{ $sisaCuti < 0 ? 'text-red-500' : 'text-[#1E3A5F]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-3xl font-bold {{ $sisaCuti < 0 ? 'text-red-500' : 'text-[#1E3A5F]' }}">
            {{ $sisaCuti }}
        </h3>
        <p class="mt-1 text-gray-400 text-xs">hari tersisa dari 12 hari</p>
    </div>

    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Total Pengajuan</p>
            <div class="flex justify-center items-center bg-green-50 rounded-lg w-8 h-8">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <h3 class="font-bold text-green-600 text-3xl">{{ $totalPengajuan }}</h3>
        <p class="mt-1 text-gray-400 text-xs">pengajuan cuti total</p>
    </div>

    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Status Jafa</p>
            <div class="flex justify-center items-center bg-purple-50 rounded-lg w-8 h-8">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
        </div>
        <h3 class="font-bold text-purple-600 text-lg">
            {{ $jafaProgress ? ucfirst($jafaProgress->status) : 'Belum ada' }}
        </h3>
        <p class="mt-1 text-gray-400 text-xs">pengajuan Jafa terakhir</p>
    </div>
</div>

{{-- Aksi Cepat + Info --}}
<div class="gap-5 grid grid-cols-2">
    <div class="bg-white p-6 border border-gray-200 rounded-xl">
        <h3 class="mb-4 font-semibold text-gray-700 text-sm">Aksi Cepat</h3>
        <div class="space-y-2.5">
            <a href="{{ route('cuti.create') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-blue-50 p-3.5 border border-transparent hover:border-blue-200 rounded-xl transition-all">
                <div class="flex justify-center items-center bg-[#1E3A5F]/10 rounded-lg w-9 h-9">
                    <svg class="w-4 h-4 text-[#1E3A5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 group-hover:text-[#1E3A5F] text-sm">Ajukan Cuti</span>
                <svg class="ml-auto w-4 h-4 text-gray-300 group-hover:text-[#1E3A5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ route('lembur.create') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-orange-50 p-3.5 border border-transparent hover:border-orange-200 rounded-xl transition-all">
                <div class="flex justify-center items-center bg-orange-100 rounded-lg w-9 h-9">
                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 group-hover:text-orange-700 text-sm">Ajukan Lembur</span>
                <svg class="ml-auto w-4 h-4 text-gray-300 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @if(auth()->user()->hasRole('dosen'))
            <a href="{{ route('jafa.create') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-green-50 p-3.5 border border-transparent hover:border-green-200 rounded-xl transition-all">
                <div class="flex justify-center items-center bg-green-100 rounded-lg w-9 h-9">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 group-hover:text-green-700 text-sm">Ajukan Surat Jafa</span>
                <svg class="ml-auto w-4 h-4 text-gray-300 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ route('serdos.create') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-purple-50 p-3.5 border border-transparent hover:border-purple-200 rounded-xl transition-all">
                <div class="flex justify-center items-center bg-purple-100 rounded-lg w-9 h-9">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-7"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 group-hover:text-purple-700 text-sm">Ajukan Surat Serdos</span>
                <svg class="ml-auto w-4 h-4 text-gray-300 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endif
        </div>
    </div>

    <div class="bg-white p-6 border border-gray-200 rounded-xl">
        <h3 class="mb-4 font-semibold text-gray-700 text-sm">Informasi Pegawai</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center py-2.5 border-gray-50 border-b">
                <span class="text-gray-500 text-sm">NIP</span>
                <span class="font-medium text-gray-800 text-sm">{{ $pegawai->nip ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2.5 border-gray-50 border-b">
                <span class="text-gray-500 text-sm">NIDN</span>
                <span class="font-medium text-gray-800 text-sm">{{ $pegawai->nidn ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2.5 border-gray-50 border-b">
                <span class="text-gray-500 text-sm">Jenis Pegawai</span>
                <span class="font-medium text-gray-800 text-sm">{{ ucfirst($pegawai->jenis_pegawai) }}</span>
            </div>
            <div class="flex justify-between items-center py-2.5 border-gray-50 border-b">
                <span class="text-gray-500 text-sm">No HP</span>
                <span class="font-medium text-gray-800 text-sm">{{ $pegawai->no_hp ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2.5">
                <span class="text-gray-500 text-sm">Status Serdos</span>
                <span class="text-sm font-medium {{ $serdosProgress ? 'text-purple-600' : 'text-gray-400' }}">
                    {{ $serdosProgress ? ucfirst($serdosProgress->status) : 'Belum ada' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection