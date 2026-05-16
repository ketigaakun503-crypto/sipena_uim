@extends('layouts.app')
@section('title', 'Persetujuan')
@section('header', 'Dashboard Persetujuan')

@section('content')
{{-- Queue Cuti --}}
<div class="mb-6">
    <h3 class="mb-3 font-semibold text-gray-700 text-sm">
        Antrian Persetujuan Cuti
        <span class="bg-yellow-100 ml-2 px-2 py-0.5 rounded-full text-yellow-700 text-xs">{{ $queueCuti->count() }}</span>
    </h3>
    <div class="space-y-3">
        @forelse($queueCuti as $approval)
        <div class="bg-white p-4 lg:p-6 border border-gray-200 rounded-xl">
            <div class="flex lg:flex-row flex-col justify-between lg:items-start gap-4">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $approval->pengajuanCuti->pegawai->nama_lengkap }}</h4>
                    <p class="mt-1 text-gray-500 text-sm">
                        {{ ucwords(str_replace('_', ' ', $approval->pengajuanCuti->jenis_cuti)) }} &bull;
                        {{ $approval->pengajuanCuti->tanggal_mulai->format('d/m/Y') }} –
                        {{ $approval->pengajuanCuti->tanggal_selesai->format('d/m/Y') }} &bull;
                        {{ $approval->pengajuanCuti->jumlah_hari }} hari
                    </p>
                    <p class="mt-1 text-gray-600 text-sm">{{ $approval->pengajuanCuti->alasan }}</p>
                    <p class="mt-1 text-blue-600 text-xs">Jabatan: {{ $approval->jabatan->nama ?? '-' }}</p>
                </div>
                <form action="{{ route('approval.cuti', $approval->id) }}" method="POST"
                    class="flex flex-col flex-shrink-0 gap-2 w-full lg:w-48">
                    @csrf
                    <textarea name="catatan" rows="2" placeholder="Catatan (opsional)"
                        class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 w-full text-sm resize-none"></textarea>
                    <div class="flex gap-2">
                        <button type="submit" name="status" value="disetujui"
                            class="flex-1 bg-green-500 hover:bg-green-600 py-2 rounded-lg font-medium text-white text-xs">
                            Setuju
                        </button>
                        <button type="submit" name="status" value="ditolak"
                            class="flex-1 bg-red-500 hover:bg-red-600 py-2 rounded-lg font-medium text-white text-xs">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 border border-gray-200 rounded-xl text-gray-400 text-sm text-center">
            Tidak ada antrian persetujuan cuti.
        </div>
        @endforelse
    </div>
</div>

{{-- Queue Lembur --}}
<div class="mb-6">
    <h3 class="mb-3 font-semibold text-gray-700 text-sm">
        Antrian Persetujuan Lembur
        <span class="bg-orange-100 ml-2 px-2 py-0.5 rounded-full text-orange-700 text-xs">{{ $queueLembur->count() }}</span>
    </h3>
    <div class="space-y-3">
        @forelse($queueLembur as $approval)
        <div class="bg-white p-4 lg:p-6 border border-gray-200 rounded-xl">
            <div class="flex lg:flex-row flex-col justify-between lg:items-start gap-4">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $approval->pengajuanLembur->pegawai->nama_lengkap }}</h4>
                    <p class="mt-1 text-gray-500 text-sm">
                        {{ \Carbon\Carbon::parse($approval->pengajuanLembur->tanggal_lembur)->format('d/m/Y') }} &bull;
                        {{ $approval->pengajuanLembur->jam_mulai }} – {{ $approval->pengajuanLembur->jam_selesai }} &bull;
                        {{ $approval->pengajuanLembur->jumlah_jam }} jam
                    </p>
                    <p class="mt-1 text-gray-600 text-sm">{{ $approval->pengajuanLembur->alasan }}</p>
                </div>
                <form action="{{ route('approval.lembur', $approval->id) }}" method="POST"
                    class="flex flex-col flex-shrink-0 gap-2 w-full lg:w-48">
                    @csrf
                    <textarea name="catatan" rows="2" placeholder="Catatan (opsional)"
                        class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 w-full text-sm resize-none"></textarea>
                    <div class="flex gap-2">
                        <button type="submit" name="status" value="disetujui"
                            class="flex-1 bg-green-500 hover:bg-green-600 py-2 rounded-lg font-medium text-white text-xs">
                            Setuju
                        </button>
                        <button type="submit" name="status" value="ditolak"
                            class="flex-1 bg-red-500 hover:bg-red-600 py-2 rounded-lg font-medium text-white text-xs">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 border border-gray-200 rounded-xl text-gray-400 text-sm text-center">
            Tidak ada antrian persetujuan lembur.
        </div>
        @endforelse
    </div>
</div>

{{-- Riwayat --}}
<div>
    <h3 class="mb-3 font-semibold text-gray-700 text-sm">Riwayat Persetujuan</h3>
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[500px] text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-left">Pegawai</th>
                        <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                        <th class="px-4 py-3 font-semibold text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $r->pengajuanCuti->pegawai->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $r->pengajuanCuti->tanggal_mulai->format('d/m/Y') }} –
                            {{ $r->pengajuanCuti->tanggal_selesai->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $r->status === 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->catatan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-gray-400 text-center">Belum ada riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection