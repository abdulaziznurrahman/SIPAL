<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPAL') - SIPAL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- LIBRARY SWEETALERT2 UNTUK NOTIFIKASI KEREN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-pattern text-slate-800 font-sans antialiased flex flex-col">

    @if(auth()->user()->role === 'admin')
        {{-- ========================================== --}}
        {{-- LAYOUT ADMIN (SIDEBAR KIRI RESPONSIF) --}}
        {{-- ========================================== --}}
        <div class="flex h-screen overflow-hidden">
            
            {{-- SIDEBAR ADMIN (Bisa ditutup di HP) --}}
            <aside id="adminSidebar" class="w-64 bg-slate-900 text-white flex flex-col shadow-2xl z-50 absolute md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
                <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
                    <a href="/" class="text-2xl font-bold tracking-wide text-white flex items-center gap-2">
                        SIPAL <span class="text-[10px] bg-blue-500 px-2 py-0.5 rounded-full uppercase tracking-wider">Admin</span>
                    </a>
                    {{-- Tombol Tutup Sidebar (Hanya muncul di HP) --}}
                    <button onclick="toggleAdminSidebar()" class="md:hidden text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4 px-2">Menu Utama</p>
                    
                    <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    
                    <a href="/admin/tools" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/tools*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Kelola Alat
                    </a>
                    
                    <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/categories*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Kategori
                    </a>

                    {{-- MENU KELOLA SISWA (BARU) --}}
                    <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/users*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Kelola Siswa
                    </a>
                </div>
            </aside>

            {{-- KONTEN ADMIN --}}
            <div class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
                {{-- Topbar Admin --}}
                <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 md:px-8 z-10 shadow-sm shrink-0">
                    <div class="flex items-center gap-4">
                        {{-- Tombol Buka Sidebar (Hanya muncul di HP) --}}
                        <button onclick="toggleAdminSidebar()" class="md:hidden text-slate-600 hover:text-blue-600 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div class="text-slate-500 font-medium hidden sm:block">Panel Administrator</div>
                    </div>
                    
                    <div class="flex items-center gap-2 md:gap-4">
                        <a href="/profile" class="flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-blue-600 transition btn-interactive">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border border-slate-300">
                            @else
                                <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                        </a>
                        
                        {{-- LOGOUT ADMIN --}}
                        <form method="POST" action="/logout" id="logout-form-admin">
                            @csrf
                            <button type="button" onclick="confirmLogout('logout-form-admin')" class="text-sm text-red-500 hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg transition btn-interactive font-medium">Logout</button>
                        </form>
                    </div>
                </header>

                {{-- Area Konten & Footer Admin --}}
                <div class="flex-1 overflow-y-auto flex flex-col">
                    <main class="p-4 md:p-8 flex-1">
                        @if(session('success'))
                            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r-lg mb-6 shadow-sm text-sm">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg mb-6 shadow-sm text-sm">{{ session('error') }}</div>
                        @endif
                        @yield('content')
                    </main>

                    {{-- FOOTER ADMIN --}}
                    <footer class="bg-white border-t border-slate-200 py-4 px-4 md:px-8 mt-auto">
                        <div class="text-center md:text-left text-sm text-slate-500">
                            &copy; {{ date('Y') }} SIPAL - Sistem Peminjaman Alat Lab. Hak Cipta Dilindungi.
                        </div>
                    </footer>
                </div>
            </div>
        </div>

    @else
        {{-- ========================================== --}}
        {{-- LAYOUT SISWA & GURU (NAVBAR ATAS) --}}
        {{-- ========================================== --}}
        <nav class="bg-slate-900/90 backdrop-blur-md border-b border-slate-700/50 text-white shadow-lg sticky top-0 z-50 relative shrink-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    
                    <a href="/" class="text-2xl font-bold tracking-wide text-white flex items-center gap-2">
                        SIPAL <span class="text-[10px] bg-blue-500 text-white px-2 py-0.5 rounded-full">Lab Komputer</span>
                    </a>

                    {{-- Menu Desktop --}}
                    <div class="hidden md:flex items-center gap-8">
                        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }} text-slate-300 hover:text-white transition">Dashboard</a>
                        <a href="/katalog" class="nav-link {{ request()->is('katalog*') ? 'active' : '' }} text-slate-300 hover:text-white transition">Katalog Alat</a>
                        <a href="/riwayat" class="nav-link {{ request()->is('riwayat') ? 'active' : '' }} text-slate-300 hover:text-white transition">Riwayat Peminjaman</a>
                    </div>

                    {{-- Profil & Logout Desktop --}}
                    <div class="hidden md:flex items-center gap-4">
                        <a href="/profile" class="flex items-center gap-2 text-sm hover:bg-slate-800 px-3 py-1.5 rounded-lg transition btn-interactive text-white">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border border-slate-600">
                            @else
                                <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center text-slate-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                            <div class="text-right">
                                <div class="font-semibold">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-slate-400 capitalize">
                                    {{-- LOGIKA LABEL GURU DI SINI --}}
                                    {{ auth()->user()->role === 'guru' ? 'Guru' : (auth()->user()->role === 'admin' ? 'Admin' : 'Siswa') }}
                                </div>
                            </div>
                        </a>
                        
                        {{-- LOGOUT SISWA/GURU DESKTOP --}}
                        <form method="POST" action="/logout" id="logout-form-siswa">
                            @csrf
                            <button type="button" onclick="confirmLogout('logout-form-siswa')" class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-1.5 rounded-lg transition btn-interactive">Logout</button>
                        </form>
                    </div>

                    {{-- Tombol Hamburger Mobile --}}
                    <div class="md:hidden flex items-center">
                        <button onclick="toggleMobileMenu()" type="button" class="text-slate-300 hover:text-white focus:outline-none p-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menu Dropdown Mobile --}}
            <div id="mobileMenu" class="md:hidden bg-slate-800 border-t border-slate-700 absolute w-full" style="display: none;">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-slate-700 hover:text-white {{ request()->is('dashboard') ? 'bg-slate-700 text-blue-400' : '' }}">Dashboard</a>
                    <a href="/katalog" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-slate-700 hover:text-white {{ request()->is('katalog*') ? 'bg-slate-700 text-blue-400' : '' }}">Katalog Alat</a>
                    <a href="/riwayat" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-slate-700 hover:text-white {{ request()->is('riwayat') ? 'bg-slate-700 text-blue-400' : '' }}">Riwayat Peminjaman</a>
                </div>
                <div class="pt-4 pb-3 border-t border-slate-700 bg-slate-800">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-slate-600">
                            @else
                                <div class="w-10 h-10 bg-slate-600 rounded-full flex items-center justify-center text-slate-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-slate-400 mt-1 capitalize">
                                {{-- LOGIKA LABEL GURU DI MOBILE --}}
                                {{ auth()->user()->role === 'guru' ? 'Guru' : (auth()->user()->role === 'admin' ? 'Admin' : 'Siswa') }} - {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="/profile" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-slate-700">Pengaturan Profil</a>
                        
                        {{-- LOGOUT SISWA/GURU MOBILE --}}
                        <form method="POST" action="/logout" id="logout-form-mobile">
                            @csrf
                            <button type="button" onclick="confirmLogout('logout-form-mobile')" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-400 hover:bg-slate-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Area Konten & Footer Siswa --}}
        <div class="flex-grow flex flex-col">
            <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex-1">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r-lg mb-6 shadow-sm text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg mb-6 shadow-sm text-sm">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>

            {{-- FOOTER SISWA --}}
            <footer class="bg-slate-900 text-slate-400 py-6 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="text-center md:text-left text-sm">
                        &copy; {{ date('Y') }} SIPAL - Sistem Peminjaman Alat Lab Komputer.
                    </div>
                </div>
            </footer>
        </div>
    @endif

    {{-- SCRIPT UNTUK MENU MOBILE & KONFIRMASI LOGOUT --}}
    <script>
        function toggleMobileMenu() {
            var menu = document.getElementById('mobileMenu');
            if (menu) {
                if (menu.style.display === 'none' || menu.style.display === '') {
                    menu.style.display = 'block';
                } else {
                    menu.style.display = 'none';
                }
            }
        }

        function toggleAdminSidebar() {
            var sidebar = document.getElementById('adminSidebar');
            if (sidebar) {
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        }

        // Fungsi Konfirmasi Logout dengan SweetAlert2
        function confirmLogout(formId) {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar dari akun ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    title: 'text-slate-800 font-bold',
                    htmlContainer: 'text-slate-500'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
</body>
</html>