@extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-900">
        <p class="text-sm text-gray-500">Total Pegawai</p>
        <h3 class="text-3xl font-bold text-blue-900 mt-1">0</h3>
        <p class="text-xs text-gray-400 mt-1">Dosen & Tendik</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Unit Kerja</p>
        <h3 class="text-3xl font-bold text-green-600 mt-1">0</h3>
        <p class="text-xs text-gray-400 mt-1">Fakultas, Prodi, Biro</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
        <p class="text-sm text-gray-500">Jabatan</p>
        <h3 class="text-3xl font-bold text-orange-600 mt-1">0</h3>
        <p class="text-xs text-gray-400 mt-1">Struktural & Akademik</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
    <p class="text-gray-500 text-sm">Anda login sebagai <span class="font-medium text-blue-900">{{ auth()->user()->getRoleNames()->first() }}</span>. Gunakan menu di sidebar untuk mengelola data kepegawaian.</p>
</div>
@endsection