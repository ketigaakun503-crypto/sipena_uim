@extends('layouts.app')
@section('title', 'Persetujuan')
@section('header', 'Dashboard Persetujuan')

@section('content')
{{-- Queue Cuti --}}
<div class="mb-8">
    <h3 class="font-semibold text-gray-700 mb-4">⏳ Antrian Persetujuan Cuti ({{ $queueCuti->count() }})</h3>
    @forelse($queueCuti as $approval)
    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <div class="flex justify-between items-start">
            <div>
                <h4 class="font-semibold text-gray-800">{{ $approval->pengajuanCuti->pegawai->nama_lengkap }}</h4>
                <p class="text-sm text-gray-500">
                    {{ ucwords(str_replace('_', ' ', $approval->pengajuanCuti->jenis_cuti)) }} •
                    {{ $approval->pengajuanCuti->tanggal_mulai->format('d/m/Y') }} –
                    {{ $approval->pengajuanCuti->tanggal_selesai->format('d/m/Y') }} •
                    {{ $approval->pengajuanCuti->jumlah_hari }} hari
                </p>
                <p class="text-sm text-gray-600 mt-1">Alasan: {{ $approval->pengajuanCuti->alasan }}</p>
                <p class="text-xs text-blue-600 mt-1">Jabatan: {{ $approval->jabatan->nama ?? '-' }}</p>
            </div>
            <form action="{{ route('approval.cuti', $approval->id) }}" method="POST" class="flex flex-col gap-2 min-w-[200px]">
                @csrf
                <textarea name="catatan" rows="2" placeholder="Catatan (opsional)"
                    class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                <div class="flex gap-2">
                    <button type="submit" name="status" value="disetujui"
                        class="flex-1 bg-green-500 text-white py-2 rounded-lg text-sm hover:bg-green-600">
                        ✅ Setuju
                    </button>
                    <button type="submit" name="status" value="ditolak"
                        class="flex-1 bg-red-500 text-white py-2 rounded-lg text-sm hover:bg-red-600">
                        ❌ Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm p-6 text-center text-gray-400">
        Tidak ada antrian persetujuan cuti.
    </div>
    @endforelse
</div>

{{-- Queue Lembur --}}
<div class="mb-8">
    <h3 class="font-semibold text-gray-700 mb-4">⏳ Antrian Persetujuan Lembur ({{ $queueLembur->count() }})</h3>
    @forelse($queueLembur as $approval)
    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <div class="flex justify-between items-start">
            <div>
                <h4 class="font-semibold text-gray-800">{{ $approval->pengajuanLembur->pegawai->nama_lengkap }}</h4>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($approval->pengajuanLembur->tanggal_lembur)->format('d/m/Y') }} •
                    {{ $approval->pengajuanLembur->jam_mulai }} – {{ $approval->pengajuanLembur->jam_selesai }} •
                    {{ $approval->pengajuanLembur->jumlah_jam }} jam
                </p>
                <p class="text-sm text-gray-600 mt-1">Alasan: {{ $approval->pengajuanLembur->alasan }}</p>
            </div>
            <form action="{{ route('approval.lembur', $approval->id) }}" method="POST" class="flex flex-col gap-2 min-w-[200px]">
                @csrf
                <textarea name="catatan" rows="2" placeholder="Catatan (opsional)"
                    class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                <div class="flex gap-2">
                    <button type="submit" name="status" value="disetujui"
                        class="flex-1 bg-green-500 text-white py-2 rounded-lg text-sm hover:bg-green-600">
                        ✅ Setuju
                    </button>
                    <button type="submit" name="status" value="ditolak"
                        class="flex-1 bg-red-500 text-white py-2 rounded-lg text-sm hover:bg-red-600">
                        ❌ Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm p-6 text-center text-gray-400">
        Tidak ada antrian persetujuan lembur.
    </div>
    @endforelse
</div>

{{-- Riwayat --}}
<div>
    <h3 class="font-semibold text-gray-700 mb-4">📋 Riwayat Persetujuan</h3>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Pegawai</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-left">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayat as $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $r->pengajuanCuti->pegawai->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $r->pengajuanCuti->tanggal_mulai->format('d/m/Y') }} –
                        {{ $r->pengajuanCuti->tanggal_selesai->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $r->status === 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $r->catatan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection