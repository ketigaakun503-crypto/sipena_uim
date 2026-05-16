<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENA UIM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex justify-center items-center bg-[#1E3A5F] p-4 min-h-screen">

    <div class="grid grid-cols-2 bg-white shadow-2xl rounded-2xl w-full max-w-4xl overflow-hidden">

        {{-- LEFT PANEL --}}
        <div class="flex flex-col justify-between bg-[#1E3A5F] p-10">
            <div>
                <div class="flex justify-center items-center bg-white/10 mb-8 rounded-xl w-12 h-12">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h1 class="mb-2 font-bold text-white text-3xl">SIPENA UIM</h1>
                <p class="text-blue-200 text-sm leading-relaxed">
                    Sistem Informasi Kepegawaian dan Administrasi<br>
                    Universitas Islam Mulia
                </p>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex flex-shrink-0 justify-center items-center bg-white/10 mt-0.5 rounded-lg w-8 h-8">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm">Manajemen Pegawai</p>
                        <p class="text-blue-300 text-xs">Data Dosen & Tendik terpusat</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex flex-shrink-0 justify-center items-center bg-white/10 mt-0.5 rounded-lg w-8 h-8">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm">Smart Leave System</p>
                        <p class="text-blue-300 text-xs">Approval cuti multi-jabatan otomatis</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex flex-shrink-0 justify-center items-center bg-white/10 mt-0.5 rounded-lg w-8 h-8">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm">E-Letter Generator</p>
                        <p class="text-blue-300 text-xs">Surat Jafa & Serdos otomatis</p>
                    </div>
                </div>
            </div>

            <p class="text-blue-400 text-xs">© {{ date('Y') }} Universitas Islam Mulia</p>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="flex flex-col justify-center p-10">
            <div class="mb-8">
                <h2 class="font-bold text-gray-800 text-2xl">Selamat Datang</h2>
                <p class="mt-1 text-gray-500 text-sm">Masuk menggunakan akun kepegawaian Anda</p>
            </div>

            @if ($errors->any())
            <div class="flex items-center gap-3 bg-red-50 mb-5 px-4 py-3 border border-red-200 rounded-xl text-red-700 text-sm">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1.5 font-medium text-gray-700 text-sm">Email</label>
                    <div class="relative">
                        <div class="left-0 absolute inset-y-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="py-2.5 pr-4 pl-10 border border-gray-300 focus:border-transparent rounded-xl focus:outline-none focus:ring-[#1E3A5F] focus:ring-2 w-full text-sm transition-all"
                            placeholder="nama@uim.ac.id">
                    </div>
                </div>

                <div>
                    <label class="block mb-1.5 font-medium text-gray-700 text-sm">Password</label>
                    <div class="relative">
                        <div class="left-0 absolute inset-y-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password"
                            class="py-2.5 pr-4 pl-10 border border-gray-300 focus:border-transparent rounded-xl focus:outline-none focus:ring-[#1E3A5F] focus:ring-2 w-full text-sm transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit"
                    class="bg-[#1E3A5F] hover:bg-[#16304f] mt-2 py-2.5 rounded-xl w-full font-semibold text-white text-sm transition-colors">
                    Login
                </button>
            </form>
        </div>
    </div>

</body>
</html>