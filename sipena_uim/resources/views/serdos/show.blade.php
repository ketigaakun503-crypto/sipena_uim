@extends('layouts.app')
@section('title', 'Detail Surat Serdos')
@section('header', 'Detail Surat Serdos')

@section('content')
<div class="max-w-2xl space-y-4">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="font-semibold text-gray-800">{{ $surat->pegawai->nama_lengkap }}</h3>
                <p class="text-xs font-mono text-gray-500 mt-1">{{ $surat->nomor_surat }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('serdos.pdf', $surat->id) }}"
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
                <p class="text-gray-400">Program Studi</p>
                <p class="font-medium">{{ $surat->program_studi }}</p>
            </div>
            <div>
                <p class="text-gray-400">Bidang Ilmu</p>
                <p class="font-medium">{{ $surat->bidang_ilmu }}</p>
            </div>
            <div>
                <p class="text-gray-400">Jumlah SKS</p>
                <p class="font-medium">{{ $surat->jumlah_sks }} SKS</p>
            </div>
            <div>
                <p class="text-gray-400">Tahun Mulai Mengajar</p>
                <p class="font-medium">{{ $surat->tahun_mulai_mengajar }}</p>
            </div>
            @if($surat->mata_kuliah)
            <div class="col-span-2">
                <p class="text-gray-400">Mata Kuliah</p>
                <p class="font-medium whitespace-pre-line">{{ $surat->mata_kuliah }}</p>
            </div>
            @endif
        </div>
    </div>

    @if(!$surat->file_scan)
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="font-semibold text-gray-700 mb-3">Upload Scan Tanda Tangan Rektor</h4>
        <form action="{{ route('serdos.upload-scan', $surat->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-3">
            @csrf
            <input type="file" name="file_scan" accept=".pdf,.jpg,.jpeg,.png"
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800">Upload</button>
        </form>
    </div>
    @else
    <div class="bg-green-50 rounded-xl p-4 text-sm text-green-700">
        ✅ File scan sudah diupload. Menunggu verifikasi Admin SDM.
    </div>
    @endif

    <a href="{{ route('serdos.index') }}" class="text-gray-500 hover:underline text-sm">← Kembali</a>
</div>
@endsection