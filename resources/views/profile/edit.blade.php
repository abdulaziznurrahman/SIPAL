@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Pengaturan Profil</h1>
    <p class="text-slate-500 text-sm mt-1">Kelola informasi akun dan keamanan Anda</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- KOLOM 1: FOTO PROFIL --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 text-center h-fit">
        <h2 class="font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Foto Profil</h2>
        
        @if(session('success') && session('tab') === 'profil')
            <div class="bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg mb-4 text-xs">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-slate-100 shadow-sm">
            @else
                <div class="w-32 h-32 bg-slate-200 rounded-full mx-auto flex items-center justify-center text-slate-400 border-4 border-slate-100 shadow-sm">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            @endif
        </div>

        <form method="POST" action="/profile/photo" enctype="multipart/form-data" class="mt-4">
            @csrf
            <input type="file" name="photo" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-3 cursor-pointer">
            @error('photo') <span class="text-xs text-red-500 block mb-2">{{ $message }}</span> @enderror
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition text-sm">Upload Foto</button>
        </form>
    </div>

    {{-- KOLOM 2: INFORMASI & PASSWORD --}}
    <div class="md:col-span-2 space-y-6">
        
        {{-- INFORMASI PROFIL --}}
                {{-- INFORMASI PROFIL (READONLY) --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Akun</h2>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">NISN / Email</label>
                        <input type="text" value="{{ $user->email }}" readonly class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-500 text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" readonly class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-500 text-sm cursor-not-allowed">
                    </div>
                </div>

                @if($user->role === 'siswa')
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                        <input type="text" value="{{ $user->class }}" readonly class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-500 text-sm cursor-not-allowed">
                    </div>
                @endif
            </div>
            
            <p class="text-xs text-red-500 mt-4">* Nama dan Kelas dikunci. Jika ada kesalahan data, silakan hubungi Admin.</p>
        </div>

        {{-- UBAH PASSWORD --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Ubah Password</h2>

            @if(session('success') && session('tab') === 'password')
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('success') }}</div>
            @endif
            @if($errors->has('current_password'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ $errors->first('current_password') }}</div>
            @endif

            <form method="POST" action="/profile/password" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold px-5 py-2 rounded-lg transition text-sm">Perbarui Password</button>
            </form>
        </div>
    </div>
</div>

@endsection