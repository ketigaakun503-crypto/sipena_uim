@extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Dashboard Pejabat Struktural')

@section('content')
{{-- Selamat Datang --}}
<div class="bg-[#1E3A5F] mb-6 p-6 rounded-2xl text-white">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-blue-200 text-sm">Selamat datang kembali,</p>
            <h2 class="mt-0.5 font-bold text-2xl">{{ $user->name }}</h2>
            <span class="inline-block bg-white/15 mt-2 px-3 py-1 border border-white/20 rounded-full text-blue-100 text-xs">
                {{ ucwords(str_replace('_', ' ', $user->getRoleNames()->first())) }}
            </span>
        </div>
        <div class="flex justify-center items-center bg-white/10 rounded-2xl w-16 h-16">
            <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
    </div>
</div>

{{-- Antrian --}}
<div class="gap-4 grid grid-cols-2 mb-6">
    <div class="bg-white p-6 border border-gray-200 rounded-xl">
        <div class="flex items-center gap-4">
            <div class="flex flex-shrink-0 justify-center items-center bg-yellow-50 rounded-xl w-12 h-12">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-gray-500 text-sm">Antrian Persetujuan Cuti</p>
                <h3 class="mt-0.5 font-bold text-gray-800 text-3xl">{{ $queueCuti }}</h3>
                <p class="mt-1 text-gray-400 text-xs">pengajuan menunggu</p>
            </div>
            @if($queueCuti > 0)
            <a href="{{ route('approval.index') }}"
                class="flex-shrink-0 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg font-medium text-[#1E3A5F] text-xs transition-colors">
                Proses →
            </a>
            @endif
        </div>
    </div>

    <div class="bg-white p-6 border border-gray-200 rounded-xl">
        <div class="flex items-center gap-4">
            <div class="flex flex-shrink-0 justify-center items-center bg-orange-50 rounded-xl w-12 h-12">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-gray-500 text-sm">Antrian Persetujuan Lembur</p>
                <h3 class="mt-0.5 font-bold text-gray-800 text-3xl">{{ $queueLembur }}</h3>
                <p class="mt-1 text-gray-400 text-xs">pengajuan menunggu</p>
            </div>
            @if($queueLembur > 0)
            <a href="{{ route('approval.index') }}"
                class="flex-shrink-0 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg font-medium text-[#1E3A5F] text-xs transition-colors">
                Proses →
            </a>
            @endif
        </div>
    </div>
</div>

{{-- Info --}}
<div class="bg-white p-6 border border-gray-200 rounded-xl">
    <h3 class="mb-4 font-semibold text-gray-700 text-sm">Aksi Cepat</h3>
    <div class="gap-3 grid grid-cols-3">
        <a href="{{ route('approval.index') }}"
            class="group flex items-center gap-3 bg-gray-50 hover:bg-blue-50 p-4 border border-transparent hover:border-blue-200 rounded-xl transition-all">
            <div class="flex justify-center items-center bg-[#1E3A5F]/10 rounded-lg w-9 h-9">
                <svg class="w-5 h-5 text-[#1E3A5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="font-medium text-gray-700 text-sm">Approval</span>
        </a>
        <a href="{{ route('cuti.create') }}"
            class="group flex items-center gap-3 bg-gray-50 hover:bg-green-50 p-4 border border-transparent hover:border-green-200 rounded-xl transition-all">
            <div class="flex justify-center items-center bg-green-100 rounded-lg w-9 h-9">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-medium text-gray-700 text-sm">Ajukan Cuti</span>
        </a>
        <a href="{{ route('jafa.create') }}"
            class="group flex items-center gap-3 bg-gray-50 hover:bg-purple-50 p-4 border border-transparent hover:border-purple-200 rounded-xl transition-all">
            <div class="flex justify-center items-center bg-purple-100 rounded-lg w-9 h-9">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="font-medium text-gray-700 text-sm">Ajukan Jafa</span>
        </a>
    </div>
</div>
@endsection