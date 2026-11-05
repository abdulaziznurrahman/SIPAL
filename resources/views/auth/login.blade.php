<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPAL - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Animasi Bulatan Cahaya */
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }
        @keyframes float-slow {
            0% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(-20px, -20px) scale(1.05); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }

        /* Animasi Form Muncul Berurutan (Staggered Fade-Up) */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .anim-form-1 { animation: slideUpFade 0.6s ease-out forwards; opacity: 0; }
        .anim-form-2 { animation: slideUpFade 0.6s ease-out 0.15s forwards; opacity: 0; }
        .anim-form-3 { animation: slideUpFade 0.6s ease-out 0.3s forwards; opacity: 0; }
        .anim-form-4 { animation: slideUpFade 0.6s ease-out 0.45s forwards; opacity: 0; }
        .anim-form-5 { animation: slideUpFade 0.6s ease-out 0.6s forwards; opacity: 0; }

        /* Gradasi Biru Elegan Sesuai Tema SIPAL */
        .bg-mesh-blue {
            background-color: #1e3a8a;
            background-image: 
                radial-gradient(at 80% 0%, hsla(200,100%,50%,1) 0, transparent 50%), 
                radial-gradient(at 0% 50%, hsla(220,100%,60%,1) 0, transparent 50%), 
                radial-gradient(at 80% 100%, hsla(240,100%,60%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(190,100%,45%,1) 0, transparent 50%);
        }

        /* Custom Input Focus Animation */
        .input-anim {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-anim:focus {
            box-shadow: 0 4px 20px -2px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4 sm:p-8 font-sans overflow-hidden">

    {{-- CONTAINER CARD UTAMA --}}
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col-reverse md:flex-row relative border border-slate-200 z-10 min-h-[600px]">
        
        {{-- ========================================== --}}
        {{-- BAGIAN KIRI: MESH GRADIENT BIRU & TEKS --}}
        {{-- ========================================== --}}
        <div class="hidden md:flex md:w-1/2 relative bg-mesh-blue items-center justify-center overflow-hidden p-10">
            
            {{-- Ornamen Bulat Bergerak (Animasi) --}}
            <div class="absolute top-0 right-0 w-80 h-80 bg-cyan-400 opacity-20 rounded-full mix-blend-screen filter blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500 opacity-30 rounded-full mix-blend-screen filter blur-3xl animate-float-slow"></div>

            {{-- Teks & Fitur di atas gradasi --}}
            <div class="relative z-10 text-white w-full max-w-md">
                
                <h2 class="text-5xl font-extrabold mb-6 tracking-tighter drop-shadow-md anim-form-1">SIPAL</h2>
                
                <p class="text-blue-100 text-sm leading-relaxed mb-8 opacity-90 anim-form-2">
                    Platform digital untuk mempermudah proses peminjaman alat Laboratorium Komputer. Cepat, akurat, dan terintegrasi.
                </p>

                {{-- List Fitur --}}
                <div class="space-y-4 mb-10 anim-form-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm font-medium">Katalog Alat Real-time</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm font-medium">Pengajuan Peminjaman Mudah</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm font-medium">Riwayat & Notifikasi Terlambat</span>
                    </div>
                </div>
                
                {{-- Teks Pengganti Tombol (Lebih Profesional) --}}
                <div class="anim-form-4 border-t border-white/20 pt-6 mt-auto">
                    <p class="text-xs text-blue-200">
                        &copy; {{ date('Y') }} SIPAL - Lab Komputer.<br>Hak Cipta Dilindungi.
                    </p>
                </div>
            </div>
            
            {{-- Lengkungan Kaca Pemisah --}}
            <div class="absolute -right-20 top-1/4 w-48 h-[150%] bg-white/5 backdrop-blur-sm rounded-full transform -rotate-12 border-r border-white/20"></div>
        </div>

        {{-- ========================================== --}}
        {{-- BAGIAN KANAN: FORM LOGIN DENGAN ANIMASI --}}
        {{-- ========================================== --}}
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center relative z-10 bg-white">
            
            {{-- Logo Kecil --}}
            <div class="mb-10 flex items-center gap-3 anim-form-1">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span class="text-2xl font-bold text-slate-800 tracking-tight">SIPAL</span>
            </div>

            <div class="mb-8 anim-form-2">
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang 👋</h1>
                <p class="text-slate-500 text-sm">Silakan masuk menggunakan akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg mb-6 text-sm flex items-center gap-2 anim-form-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div class="anim-form-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIS</label>
                    <input type="text" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Masukkan NIS Anda"
                        class="input-anim w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white">
                </div>

                <div class="anim-form-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="input-anim w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white">
                </div>

                {{-- TOMBOL DENGAN EFEK GLOW & ANIMASI --}}
                <div class="anim-form-4 pt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/60 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        Masuk ke Sistem
                    </button>
                </div>
            </form>

            {{-- Teks Bawah (Disembunyikan di desktop karena sudah ada di panel kiri) --}}
            <p class="text-center text-xs text-slate-400 mt-10 md:hidden">&copy; {{ date('Y') }} SIPAL. Hak Cipta Dilindungi.</p>
        </div>

    </div>

</body>
</html>