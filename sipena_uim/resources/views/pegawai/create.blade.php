@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('header', 'Tambah Pegawai')

@section('content')
<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Foto Profil --}}
        <div class="flex items-center gap-5 pb-4 border-b border-gray-100">
            <div id="foto-preview" class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-gray-200 overflow-hidden flex-shrink-0">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Foto Profil</p>
                <input type="file" name="foto" id="foto-input" accept="image/jpg,image/jpeg,image/png"
                    class="text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#1E3A5F] file:text-white hover:file:bg-[#16304f] file:cursor-pointer"
                    onchange="previewFoto(this)">
                <p class="text-xs text-gray-400 mt-1">Format: JPG/PNG, maks. 2MB (opsional)</p>
            </div>
        </div>

        <p class="text-sm font-semibold text-gray-700 pt-1">Data Pribadi</p>

        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                    placeholder="Untuk Tendik">
                @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
                <input type="text" name="nidn" value="{{ old('nidn') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm"
                    placeholder="Untuk Dosen">
                @error('nidn')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pegawai <span class="text-red-500">*</span></label>
                <select name="jenis_pegawai" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                    <option value="">-- Pilih --</option>
                    <option value="dosen" {{ old('jenis_pegawai') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="tendik" {{ old('jenis_pegawai') === 'tendik' ? 'selected' : '' }}>Tendik</option>
                </select>
                @error('jenis_pegawai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                    <option value="pensiun" {{ old('status') === 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="2"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">{{ old('alamat') }}</textarea>
            </div>
        </div>

        <hr class="my-2">
        <p class="text-sm font-semibold text-gray-700">Akun Login</p>

        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
                @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <hr class="my-2">
        <p class="text-sm font-semibold text-gray-700">Jabatan Utama</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jabatan (opsional)</label>
            <select name="jabatan_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1E3A5F] focus:outline-none text-sm">
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                        {{ $jabatan->nama }} - {{ $jabatan->unitKerja->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-[#1E3A5F] text-white px-6 py-2 rounded-lg hover:bg-[#16304f] text-sm font-medium">Simpan</button>
            <a href="{{ route('pegawai.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm">Batal</a>
        </div>
    </form>
</div>

<script>
function previewFoto(input) {
    const preview = document.getElementById('foto-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection