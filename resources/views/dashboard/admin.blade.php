@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin SDM')

@section('content')
<div class="gap-4 grid grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="bg-white p-4 lg:p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Total Pegawai</p>
            <div class="flex justify-center items-center bg-blue-50 rounded-lg w-8 h-8">
                <svg class="w-4 h-4 text-[#1E3A5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="font-bold text-[#1E3A5F] text-2xl lg:text-3xl">{{ $stats['total_pegawai'] }}</h3>
        <p class="mt-1 text-gray-400 text-xs">Dosen: {{ $stats['total_dosen'] }} &bull; Tendik: {{ $stats['total_tendik'] }}</p>
    </div>

    <div class="bg-white p-4 lg:p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Cuti Menunggu</p>
            <div class="flex justify-center items-center bg-yellow-50 rounded-lg w-8 h-8">
                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <h3 class="font-bold text-yellow-600 text-2xl lg:text-3xl">{{ $stats['cuti_menunggu'] }}</h3>
        <p class="mt-1 text-gray-400 text-xs">Perlu diproses</p>
    </div>

    <div class="bg-white p-4 lg:p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Jafa Pending</p>
            <div class="flex justify-center items-center bg-orange-50 rounded-lg w-8 h-8">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <h3 class="font-bold text-orange-600 text-2xl lg:text-3xl">{{ $stats['jafa_menunggu'] }}</h3>
        <p class="mt-1 text-gray-400 text-xs">Perlu diverifikasi</p>
    </div>

    <div class="bg-white p-4 lg:p-5 border border-gray-200 rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide">Serdos Pending</p>
            <div class="flex justify-center items-center bg-purple-50 rounded-lg w-8 h-8">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
        </div>
        <h3 class="font-bold text-purple-600 text-2xl lg:text-3xl">{{ $stats['serdos_menunggu'] }}</h3>
        <p class="mt-1 text-gray-400 text-xs">Perlu diverifikasi</p>
    </div>
</div>

<div class="gap-5 grid grid-cols-1 lg:grid-cols-3">
    <div class="lg:col-span-2 bg-white p-5 border border-gray-200 rounded-xl">
        <div class="mb-4">
            <h3 class="font-semibold text-gray-800 text-sm">Tren Pengajuan Cuti {{ now()->year }}</h3>
        </div>
        <canvas id="chartCuti" height="100"></canvas>
    </div>

    <div class="bg-white p-5 border border-gray-200 rounded-xl">
        <h3 class="mb-4 font-semibold text-gray-800 text-sm">Aksi Cepat</h3>
        <div class="space-y-2">
            <a href="{{ route('pegawai.create') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-blue-50 p-3 border border-transparent hover:border-blue-200 rounded-xl transition-all">
                <div class="flex flex-shrink-0 justify-center items-center bg-[#1E3A5F]/10 rounded-lg w-8 h-8">
                    <svg class="w-4 h-4 text-[#1E3A5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 text-sm">Tambah Pegawai</span>
            </a>
            <a href="{{ route('verifikasi.index') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-orange-50 p-3 border border-transparent hover:border-orange-200 rounded-xl transition-all">
                <div class="flex flex-shrink-0 justify-center items-center bg-orange-100 rounded-lg w-8 h-8">
                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 text-sm">Verifikasi Jafa/Serdos</span>
            </a>
            <a href="{{ route('laporan.pegawai') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-green-50 p-3 border border-transparent hover:border-green-200 rounded-xl transition-all">
                <div class="flex flex-shrink-0 justify-center items-center bg-green-100 rounded-lg w-8 h-8">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 text-sm">Laporan Kepegawaian</span>
            </a>
            <a href="{{ route('laporan.cuti') }}"
                class="group flex items-center gap-3 bg-gray-50 hover:bg-purple-50 p-3 border border-transparent hover:border-purple-200 rounded-xl transition-all">
                <div class="flex flex-shrink-0 justify-center items-center bg-purple-100 rounded-lg w-8 h-8">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-medium text-gray-700 text-sm">Laporan Cuti & Lembur</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chartCuti').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Pengajuan Cuti',
            data: @json(array_values($chartCuti)),
            backgroundColor: 'rgba(30, 58, 95, 0.85)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endsection