@extends('layouts.app')
@section('title', 'Detail Surat Jafa')
@section('header', 'Detail Surat Jafa')

@section('content')
<div class="max-w-2xl space-y-4">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="font-semibold text-gray-800">{{ $surat->pegawai->nama_lengkap }}</h3>
                <p class="text-xs font-mono text-gray-500 mt-1">{{ $surat->nomor_surat }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('jafa.pdf', $surat->id) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    📄 Download PDF
                </a>
                <span class="px-3 py-2 rounded-full text-sm font-medium
                    {{ $surat->status === 'diverifikasi' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $surat->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $surat->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                    {{ ucfirst($surat->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Jabatan Diajukan</p>
                <p class="font-medium">{{ $surat->jabatan_fungsional_diajukan }}</p>
            </div>
            <div>
                <p class="text-gray-400">Jabatan Sekarang</p>
                <p class="font-medium">{{ $surat->jabatan_fungsional_sekarang }}</p>
            </div>
            <div>
                <p class="text-gray-400">Pangkat/Golongan</p>
                <p class="font-medium">{{ $surat->pangkat_golongan }}</p>
            </div>
            <div>
                <p class="text-gray-400">TMT Pangkat</p>
                <p class="font-medium">{{ $surat->tmt_pangkat->format('d F Y') }}</p>
            </div>
            @if($surat->daftar_karya)
            <div class="col-span-2">
                <p class="text-gray-400">Daftar Karya Ilmiah</p>
                <p class="font-medium whitespace-pre-line">{{ $surat->daftar_karya }}</p>
            </div>
            @endif
            @if($surat->catatan)
            <div class="col-span-2">
                <p class="text-gray-400">Catatan Admin</p>
                <p class="font-medium text-red-600">{{ $surat->catatan }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Upload Scan --}}
    @if(!$surat->file_scan)
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="font-semibold text-gray-700 mb-3">Upload Scan Tanda Tangan Rektor</h4>
        <form action="{{ route('jafa.upload-scan', $surat->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-3">
            @csrf
            <input type="file" name="file_scan" accept=".pdf,.jpg,.jpeg,.png"
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800">
                Upload
            </button>
        </form>
    </div>
    @else
    <div class="bg-green-50 rounded-xl p-4 text-sm text-green-700">
        ✅ File scan sudah diupload. Menunggu verifikasi Admin SDM.
    </div>
    @endif

    <a href="{{ route('jafa.index') }}" class="text-gray-500 hover:underline text-sm">← Kembali</a>
</div>
@endsection