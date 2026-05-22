<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIPENA UIM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    {{-- OVERLAY (mobile) --}}
    <div id="sidebar-overlay"
        class="hidden lg:hidden z-40 fixed inset-0 bg-black/50"
        onclick="toggleSidebar()">
    </div>

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="top-0 left-0 z-50 fixed flex flex-col bg-[#1E3A5F] shadow-xl w-64 h-screen text-white transition-transform -translate-x-full lg:translate-x-0 duration-300">

        {{-- Logo --}}
        <div class="flex justify-between items-center px-6 py-5 border-white/10 border-b">
            <div>
                <h1 class="font-bold text-lg tracking-wide">SIPENA UIM</h1>
                <p class="mt-0.5 text-blue-200 text-xs truncate">{{ auth()->user()->name }}</p>
                <span class="inline-block bg-white/10 mt-1.5 px-2 py-0.5 border border-white/20 rounded-full text-blue-100 text-xs">
                    {{ ucwords(str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? '-')) }}
                </span>
            </div>
            {{-- Close button mobile --}}
            <button onclick="toggleSidebar()" class="lg:hidden hover:bg-white/10 p-1 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-3 overflow-y-auto">
            <ul class="space-y-0.5 px-3">

                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </li>

                @role('admin_sdm')
                <li class="px-3 pt-4 pb-1">
                    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">Master Data</span>
                </li>
                <li>
                    <a href="{{ route('unit-kerja.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('unit-kerja.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Unit Kerja
                    </a>
                </li>
                <li>
                    <a href="{{ route('jabatan.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('jabatan.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Jabatan
                    </a>
                </li>
                <li class="px-3 pt-4 pb-1">
                    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">Kepegawaian</span>
                </li>
                <li>
                    <a href="{{ route('pegawai.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('pegawai.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Data Pegawai
                    </a>
                </li>
                @endrole

                @hasanyrole('rektor|wakil_rektor|dekan|kaprodi|ka_biro|dosen|tendik')
<li class="px-3 pt-4 pb-1">
    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">Pengajuan</span>
</li>
                <li>
                    <a href="{{ route('cuti.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('cuti.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Cuti
                    </a>
                </li>
                <li>
                    <a href="{{ route('lembur.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('lembur.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lembur
                    </a>
                </li>
                @endhasanyrole

                @hasanyrole('admin_sdm|rektor|wakil_rektor|dekan|kaprodi|ka_biro')
                <li class="px-3 pt-4 pb-1">
                    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">Persetujuan</span>
                </li>
                <li>
                    <a href="{{ route('approval.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('approval.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Approval
                    </a>
                </li>
                @endhasanyrole

                @hasanyrole('dosen|admin_sdm|rektor|wakil_rektor|dekan|kaprodi|ka_biro')
                <li class="px-3 pt-4 pb-1">
                    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">E-Letter</span>
                </li>
                <li>
                    <a href="{{ route('jafa.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('jafa.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Surat Jafa
                    </a>
                </li>
                <li>
                    <a href="{{ route('serdos.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('serdos.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        Surat Serdos
                    </a>
                </li>
                @endhasanyrole

                @role('admin_sdm')
                <li class="px-3 pt-4 pb-1">
                    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">Verifikasi</span>
                </li>
                <li>
                    <a href="{{ route('verifikasi.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('verifikasi.*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Verifikasi Berkas
                    </a>
                </li>
                <li class="px-3 pt-4 pb-1">
                    <span class="font-semibold text-blue-300/70 text-xs uppercase tracking-widest">Laporan</span>
                </li>
                <li>
                    <a href="{{ route('laporan.pegawai') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('laporan.pegawai*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Lap. Pegawai
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.cuti') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('laporan.cuti*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Lap. Cuti
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.lembur') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('laporan.lembur*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lap. Lembur
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.jafa-serdos') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                        {{ request()->routeIs('laporan.jafa*') ? 'bg-white/15 text-white font-medium' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-7"/>
                        </svg>
                        Lap. Jafa/Serdos
                    </a>
                </li>
                @endrole

            </ul>
        </nav>

        {{-- Logout --}}
        <div class="p-3 border-white/10 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 hover:bg-red-500/20 px-3 py-2.5 rounded-lg w-full text-red-300 hover:text-red-200 text-sm transition-all">
                    <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="lg:ml-64 min-h-screen">

        {{-- TOP BAR --}}
        <header class="top-0 z-40 sticky flex justify-between items-center bg-white px-4 lg:px-8 py-4 border-gray-200 border-b">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile only) --}}
                <button onclick="toggleSidebar()" class="lg:hidden hover:bg-gray-100 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h2 class="font-semibold text-gray-700 text-sm lg:text-base">@yield('header')</h2>
            </div>

            {{-- Notifikasi --}}
            <div class="relative">
                @php $jumlahNotif = auth()->user()->notifikasiTidakDibaca()->count(); @endphp
                <button onclick="document.getElementById('dropdown-notif').classList.toggle('hidden')"
                    class="relative hover:bg-gray-100 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($jumlahNotif > 0)
                    <span class="-top-0.5 -right-0.5 absolute flex justify-center items-center bg-red-500 rounded-full w-4 h-4 font-medium text-white text-xs">
                        {{ $jumlahNotif > 9 ? '9+' : $jumlahNotif }}
                    </span>
                    @endif
                </button>

                <div id="dropdown-notif" class="hidden right-0 z-50 absolute bg-white shadow-lg mt-2 border border-gray-100 rounded-xl w-72 lg:w-80 overflow-hidden">
                    <div class="flex justify-between items-center bg-gray-50 px-4 py-3 border-b">
                        <span class="font-semibold text-gray-700 text-sm">Notifikasi</span>
                        <form action="{{ route('notifikasi.baca-semua') }}" method="POST">
                            @csrf
                            <button class="text-blue-600 text-xs hover:underline">Tandai semua dibaca</button>
                        </form>
                    </div>
                    <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
                        @forelse(auth()->user()->notifikasis()->limit(10)->get() as $notif)
                        <div class="px-4 py-3 hover:bg-gray-50 transition-colors {{ !$notif->dibaca ? 'bg-blue-50/50 border-l-2 border-blue-400' : '' }}">
                            <p class="font-medium text-gray-800 text-sm">{{ $notif->judul }}</p>
                            <p class="mt-0.5 text-gray-500 text-xs leading-relaxed">{{ $notif->pesan }}</p>
                            <p class="mt-1 text-gray-400 text-xs">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                        @empty
                        <div class="px-4 py-8 text-gray-400 text-sm text-center">Tidak ada notifikasi</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <div class="p-4 lg:p-6">
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 mb-5 px-4 py-3 border border-green-200 rounded-xl text-green-800 text-sm">
                <svg class="flex-shrink-0 w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 mb-5 px-4 py-3 border border-red-200 rounded-xl text-red-800 text-sm">
                <svg class="flex-shrink-0 w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const overlay  = document.getElementById('sidebar-overlay');
            const isOpen   = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }

        // Tutup notif kalau klik di luar
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('dropdown-notif');
            if (!e.target.closest('.relative') && dropdown) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

</body>
</html>