@extends('layouts.app')
@section('title', 'Detail Pegawai')
@section('header', 'Detail Pegawai')

@section('content')
<div class="grid grid-cols-3 gap-6">

    {{-- Info Pegawai --}}
    <div class="col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $pegawai->nama_lengkap }}</h3>
                <p class="text-gray-500 text-sm">{{ $pegawai->email }}</p>
            </div>
            <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800">Edit</a>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">NIP</p>
                <p class="font-medium">{{ $pegawai->nip ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">NIDN</p>
                <p class="font-medium">{{ $pegawai->nidn ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Jenis Pegawai</p>
                <p class="font-medium">{{ ucfirst($pegawai->jenis_pegawai) }}</p>
            </div>
            <div>
                <p class="text-gray-400">Jenis Kelamin</p>
                <p class="font-medium">{{ $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tempat, Tgl Lahir</p>
                <p class="font-medium">{{ $pegawai->tempat_lahir ?? '-' }}, {{ $pegawai->tanggal_lahir ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">No HP</p>
                <p class="font-medium">{{ $pegawai->no_hp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Status</p>
                <span class="px-2 py-1 rounded-full text-xs font-medium
                    {{ $pegawai->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($pegawai->status) }}
                </span>
            </div>
            <div>
                <p class="text-gray-400">Sisa Cuti</p>
                <p class="font-medium text-blue-900">{{ $pegawai->sisa_cuti }} hari</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-400">Alamat</p>
                <p class="font-medium">{{ $pegawai->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Jabatan Aktif + Assign --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h4 class="font-semibold text-gray-700 mb-3">Jabatan Aktif</h4>
            <div class="space-y-2">
                @forelse($pegawai->jabatanAktif as $jabatan)
                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $jabatan->nama }}</p>
                        <p class="text-xs text-gray-400">{{ $jabatan->unitKerja->nama }}</p>
                        <span class="text-xs {{ $jabatan->pivot->jenis === 'rangkap' ? 'text-orange-500' : 'text-blue-500' }}">
                            {{ ucfirst($jabatan->pivot->jenis) }}
                        </span>
                    </div>
                    @if($jabatan->pivot->jenis === 'rangkap')
                    <form action="{{ route('pegawai.revoke-jabatan', [$pegawai->id, $jabatan->id]) }}" method="POST"
                        onsubmit="return confirm('Nonaktifkan jabatan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 text-xs">Revoke</button>
                    </form>
                    @endif
                </div>
                @empty
                <p class="text-gray-400 text-sm">Belum ada jabatan aktif.</p>
                @endforelse
            </div>
        </div>

        {{-- Form Assign Jabatan Rangkap --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h4 class="font-semibold text-gray-700 mb-3">Tambah Jabatan Rangkap</h4>
            <form action="{{ route('pegawai.assign-jabatan', $pegawai->id) }}" method="POST" class="space-y-3">
                @csrf
                <select name="jabatan_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}">
                            {{ $jabatan->nama }} - {{ $jabatan->unitKerja->nama }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="jenis" value="rangkap">
                <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg text-sm hover:bg-orange-600">
                    + Assign Jabatan Rangkap
                </button>
            </form>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('pegawai.index') }}" class="text-gray-500 hover:underline text-sm">← Kembali ke daftar pegawai</a>
</div>
@endsection