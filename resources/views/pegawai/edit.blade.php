@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('header', 'Edit Pegawai')

@section('content')
<div class="max-w-2xl bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        {{-- Foto Profil --}}
<div class="flex items-center gap-5 pb-4 border-b border-gray-100">
    <div id="foto-preview" class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-gray-200 overflow-hidden flex-shrink-0">
        @if($pegawai->foto)
            <img src="{{ asset($pegawai->foto) }}" class="w-full h-full object-cover">
        @else
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        @endif
    </div>
    <div>
        <p class="text-sm font-medium text-gray-700 mb-1">Foto Profil</p>
        <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png"
            class="text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#1E3A5F] file:text-white hover:file:bg-[#16304f] file:cursor-pointer"
            onchange="previewFoto(this)">
        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
    </div>
</div>

        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
                <input type="text" name="nidn" value="{{ old('nidn', $pegawai->nidn) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pegawai <span class="text-red-500">*</span></label>
                <select name="jenis_pegawai" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="dosen" {{ old('jenis_pegawai', $pegawai->jenis_pegawai) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="tendik" {{ old('jenis_pegawai', $pegawai->jenis_pegawai) === 'tendik' ? 'selected' : '' }}>Tendik</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="aktif" {{ old('status', $pegawai->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $pegawai->status) === 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                    <option value="pensiun" {{ old('status', $pegawai->status) === 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="2"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('alamat', $pegawai->alamat) }}</textarea>
            </div>
        </div>

        <hr class="my-2">
        <p class="text-sm font-semibold text-gray-700">Akun Login</p>

        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $pegawai->user->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role', $pegawai->user->getRoleNames()->first()) === $role->name ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Update</button>
            <a href="{{ route('pegawai.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection